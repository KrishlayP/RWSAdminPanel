import { StatusBar } from "expo-status-bar";
import { useCallback, useEffect, useMemo, useRef, useState } from "react";
import {
  Animated,
  Easing,
  FlatList,
  RefreshControl,
  Text,
  TouchableOpacity,
} from "react-native";
import { Snackbar } from "react-native-paper";
import { useTranslation } from "react-i18next";
import { SafeAreaView } from "react-native-safe-area-context";

import ApiStatusBanner from "../components/ApiStatusBanner";
import BottomTabs from "../components/BottomTabs";
import DrawerMenu from "../components/DrawerMenu";
import FeatureGrid from "../components/FeatureGrid";
import HeroBanner from "../components/HeroBanner";
import HomeHeader from "../components/HomeHeader";
import MediaItemCard from "../components/MediaItemCard";
import MediaTypeTabs from "../components/MediaTypeTabs";
import NotificationPrompt from "../components/NotificationPrompt";
import PhoneOtpModal from "../components/PhoneOtpModal";
import PremiumCard from "../components/PremiumCard";
import ShortcutList from "../components/ShortcutList";
import SubscriptionModal from "../components/SubscriptionModal";
import { CATEGORY_CONTENT, MEDIA_ITEMS } from "../data/appData";
import { fetchRemoteContent } from "../services/contentService";
import { loadUserLibrary, saveUserLibrary } from "../services/localStore";
import { downloadMediaItem } from "../services/mediaDownloadService";
import { styles } from "../styles/styles";
import { getStepAnimationStyle } from "../utils/animations";
import AccountScreen from "./AccountScreen";
import CategoriesScreen from "./CategoriesScreen";
import CategoryScreen from "./CategoryScreen";
import LanguageScreen from "./LanguageScreen";
import SplashScreen from "./SplashScreen";

const FREE_WALLPAPER_DOWNLOAD_LIMIT = 2;

function isWallpaperDownload(item) {
  return item?.type === "wallpaper" || item?.type === "image";
}

export default function HomeScreen() {
  const [activeType, setActiveType] = useState("wallpaper");
  const [activeTab, setActiveTab] = useState("home");
  const [selectedPage, setSelectedPage] = useState("");
  const [selectedCategoryId, setSelectedCategoryId] = useState("");
  const [isDrawerOpen, setIsDrawerOpen] = useState(false);
  const [appStep, setAppStep] = useState("splash");
  const [showNotificationPrompt, setShowNotificationPrompt] = useState(true);
  const [phoneUser, setPhoneUser] = useState(null);
  const [isOtpVisible, setIsOtpVisible] = useState(false);
  const [favorites, setFavorites] = useState([]);
  const [downloads, setDownloads] = useState([]);
  const [subscription, setSubscription] = useState({
    isActive: false,
    activatedAt: null,
  });
  const [settings, setSettings] = useState({
    autoPlayPreviews: true,
    dailyReminders: true,
  });
  const [isSubscriptionVisible, setIsSubscriptionVisible] = useState(false);
  const [isRefreshingContent, setIsRefreshingContent] = useState(false);
  const [contentStatus, setContentStatus] = useState("offline");
  const [contentError, setContentError] = useState("");
  const [lastContentUpdated, setLastContentUpdated] = useState(null);
  const [snackbarMessage, setSnackbarMessage] = useState("");
  const [isLibraryReady, setIsLibraryReady] = useState(false);
  const [contentData, setContentData] = useState({
    categories: Object.entries(CATEGORY_CONTENT).map(([id, category]) => ({
      id,
      title: category.title,
      description: category.description,
    })),
    categoryContent: CATEGORY_CONTENT,
    mediaItems: MEDIA_ITEMS,
  });
  const pendingProtectedActionRef = useRef(null);
  const pendingSubscriptionActionRef = useRef(null);
  const { t, i18n } = useTranslation();
  const [selectedLanguage, setSelectedLanguage] = useState(
    i18n.resolvedLanguage || i18n.language || "hi",
  );
  const drawerX = useRef(new Animated.Value(-280)).current;
  const stepAnim = useRef(new Animated.Value(0)).current;

  const normalizeLibraryItem = useCallback((item) => {
    if (!item) return null;

    return {
      ...item,
      categoryId: item.categoryId || item.category_id || "",
      title: item.title || item.id || "Untitled",
      type: item.type || "media",
    };
  }, []);

  useEffect(() => {
    setSelectedLanguage(i18n.resolvedLanguage || i18n.language || "hi");
  }, [i18n.language, i18n.resolvedLanguage]);

  const visibleItems = useMemo(
    () =>
      contentData.mediaItems.filter((item) => item.type === activeType),
    [activeType, contentData.mediaItems],
  );

  const favoriteIds = useMemo(
    () => favorites.map((item) => item.id),
    [favorites],
  );

  const wallpaperDownloadCount = useMemo(
    () => downloads.filter(isWallpaperDownload).length,
    [downloads],
  );

  const remainingFreeWallpaperDownloads = Math.max(
    0,
    FREE_WALLPAPER_DOWNLOAD_LIMIT - wallpaperDownloadCount,
  );

  const loadContent = useCallback(async () => {
    setIsRefreshingContent(true);

    try {
      const remoteContent = await fetchRemoteContent();

      if (!remoteContent) {
        throw new Error("API URL is not configured.");
      }

      setContentData({
        categories: remoteContent.categories || [],
        categoryContent: remoteContent.categoryContent || CATEGORY_CONTENT,
        mediaItems: remoteContent.mediaItems || MEDIA_ITEMS,
      });
      setContentStatus("live");
      setContentError("");
      setLastContentUpdated(new Date());
    } catch (err) {
      setContentStatus("offline");
      setContentError(err.message || "Could not load live content.");
      setContentData({
        categories: Object.entries(CATEGORY_CONTENT).map(([id, category]) => ({
          id,
          title: category.title,
          description: category.description,
        })),
        categoryContent: CATEGORY_CONTENT,
        mediaItems: MEDIA_ITEMS,
      });
    } finally {
      setIsRefreshingContent(false);
    }
  }, []);

  useEffect(() => {
    loadContent();
  }, [loadContent]);

  useEffect(() => {
    let isMounted = true;

    loadUserLibrary()
      .then((library) => {
        if (!isMounted) return;

        setFavorites(library.favorites.map(normalizeLibraryItem).filter(Boolean));
        setDownloads(library.downloads.map(normalizeLibraryItem).filter(Boolean));
        setPhoneUser(library.phoneUser);
        setSubscription(library.subscription);
        setSettings(library.settings);
      })
      .finally(() => {
        if (isMounted) {
          setIsLibraryReady(true);
        }
      });

    return () => {
      isMounted = false;
    };
  }, [normalizeLibraryItem]);

  useEffect(() => {
    if (!isLibraryReady) return;

    saveUserLibrary({
      downloads,
      favorites,
      phoneUser,
      subscription,
      settings,
    });
  }, [downloads, favorites, isLibraryReady, phoneUser, subscription, settings]);

  const closeDrawer = useCallback(
    (immediate = false) => {
      if (immediate) {
        drawerX.setValue(-280);
        setIsDrawerOpen(false);
        return;
      }

      Animated.timing(drawerX, {
        toValue: -280,
        duration: 180,
        easing: Easing.in(Easing.ease),
        useNativeDriver: true,
      }).start(() => setIsDrawerOpen(false));
    },
    [drawerX],
  );

  const openPage = useCallback(
    (pageId) => {
      closeDrawer(true);
      setActiveTab("home");
      if (pageId === "logout") {
        setPhoneUser(null);
        setSelectedPage("profile");
        return;
      }

      setSelectedPage(pageId);
    },
    [closeDrawer],
  );

  const openCategory = useCallback(
    (categoryId) => {
      closeDrawer(true);
      setActiveTab("home");
      setSelectedCategoryId(categoryId);
    },
    [closeDrawer],
  );

  const changeTab = useCallback((tabId) => {
    setSelectedPage("");
    setSelectedCategoryId("");
    setActiveTab(tabId);
  }, []);

  const requestProtectedAction = useCallback(
    (actionTitle, item = null) => {
      const completeDownload = async (subscriptionOverride = false) => {
        if (item) {
          const normalizedItem = normalizeLibraryItem(item);

          if (!normalizedItem) {
            return;
          }

          const alreadyDownloaded = downloads.some(
            (download) => download.id === normalizedItem.id,
          );

          if (
            isWallpaperDownload(normalizedItem) &&
            !alreadyDownloaded &&
            !subscription.isActive &&
            !subscriptionOverride &&
            wallpaperDownloadCount >= FREE_WALLPAPER_DOWNLOAD_LIMIT
          ) {
            pendingSubscriptionActionRef.current = () => completeDownload(true);
            setIsSubscriptionVisible(true);
            return;
          }

          let downloadResult = null;

          try {
            downloadResult = await downloadMediaItem(normalizedItem);
            setSnackbarMessage(downloadResult.message);
          } catch (err) {
            setSnackbarMessage(err.message || "Download failed. Please try again.");
            return;
          }

          setDownloads((current) => {
            if (current.some((download) => download.id === normalizedItem.id)) {
              return current;
            }

            return [
              {
                ...normalizedItem,
                downloadedAt: Date.now(),
                localUri: downloadResult?.localUri,
              },
              ...current,
            ];
          });
        }

        setActiveTab("downloads");
        setSelectedPage("downloads");
      };

      if (phoneUser) {
        completeDownload();
        return;
      }

      pendingProtectedActionRef.current = completeDownload;
      setIsOtpVisible(true);
    },
    [downloads, normalizeLibraryItem, phoneUser, subscription.isActive, wallpaperDownloadCount],
  );

  const closeOtp = useCallback(() => {
    setIsOtpVisible(false);
    pendingProtectedActionRef.current = null;
  }, []);

  const completePhoneLogin = useCallback((phoneNumber) => {
    setPhoneUser({ phone: phoneNumber });
    setIsOtpVisible(false);

    if (pendingProtectedActionRef.current) {
      pendingProtectedActionRef.current();
      pendingProtectedActionRef.current = null;
    }
  }, []);

  const closeSubscription = useCallback(() => {
    setIsSubscriptionVisible(false);
    pendingSubscriptionActionRef.current = null;
  }, []);

  const completeSubscription = useCallback(() => {
    setSubscription({
      isActive: true,
      activatedAt: Date.now(),
    });
    setIsSubscriptionVisible(false);

    if (pendingSubscriptionActionRef.current) {
      const pendingAction = pendingSubscriptionActionRef.current;
      pendingSubscriptionActionRef.current = null;
      pendingAction();
    }
  }, []);

  const openDrawer = useCallback(() => {
    if (appStep !== "home") return;

    setIsDrawerOpen(true);

    Animated.timing(drawerX, {
      toValue: 0,
      duration: 220,
      easing: Easing.out(Easing.ease),
      useNativeDriver: true,
    }).start();
  }, [appStep, drawerX]);

  const handleSelectLanguage = useCallback(
    (languageId) => {
      setSelectedLanguage(languageId);
      i18n.changeLanguage(languageId);
      setAppStep("home");
    },
    [i18n],
  );

  const hideNotificationPrompt = useCallback(() => {
    setShowNotificationPrompt(false);
  }, []);

  const selectSearchSuggestion = useCallback(
    (item) => {
      openCategory(item.categoryId);
    },
    [openCategory],
  );

  const toggleFavorite = useCallback((item) => {
    setFavorites((current) => {
      const normalizedItem = normalizeLibraryItem(item);

      if (!normalizedItem) {
        return current;
      }

      if (current.some((favorite) => favorite.id === normalizedItem.id)) {
        return current.filter((favorite) => favorite.id !== normalizedItem.id);
      }

      return [{ ...normalizedItem, favoritedAt: Date.now() }, ...current];
    });
  }, [normalizeLibraryItem]);

  const toggleSetting = useCallback((key) => {
    setSettings((current) => ({
      ...current,
      [key]: !current[key],
    }));
  }, []);

  const clearDownloads = useCallback(() => {
    setDownloads([]);
    setSnackbarMessage("Cached downloads cleared.");
  }, []);

  const renderMediaItem = useCallback(
    ({ index, item }) => (
        <MediaItemCard
        isFavorite={favoriteIds.includes(item.id)}
        index={index}
        item={item}
        onDownload={requestProtectedAction}
        onOpenCategory={openCategory}
        onToggleFavorite={toggleFavorite}
        t={t}
      />
    ),
    [favoriteIds, openCategory, requestProtectedAction, toggleFavorite, t],
  );

  const selectedCategory = useMemo(() => {
    const category =
      contentData.categoryContent[selectedCategoryId] ||
      contentData.categoryContent.wallpapers ||
      CATEGORY_CONTENT.wallpapers;

    return {
      ...category,
      items: (category.items || []).flatMap((item) => {
        const images = Array.isArray(item.images) ? item.images.filter(Boolean) : [];

        if (item.type !== "image" || images.length <= 1) {
          return [item];
        }

        return images.map((image, imageIndex) => ({
          ...item,
          id: `${item.id}-image-${imageIndex + 1}`,
          image,
          title:
            images.length > 1
              ? `${item.title} ${imageIndex + 1}`
              : item.title,
        }));
      }),
    };
  }, [contentData.categoryContent, selectedCategoryId]);

  const dynamicCategories = useMemo(
    () =>
      contentData.categories.filter(
        (category) => contentData.categoryContent[category.id],
      ),
    [contentData.categories, contentData.categoryContent],
  );

  const getCategoryItemCount = useCallback(
    (categoryId) =>
      (contentData.categoryContent[categoryId]?.items || []).reduce(
        (total, item) =>
          total +
          Math.max(
            1,
            Array.isArray(item.images) ? item.images.filter(Boolean).length : 0,
          ),
        0,
      ),
    [contentData.categoryContent],
  );

  const homeHeader = useMemo(
    () => (
      <>
        <ApiStatusBanner
          error={contentError}
          isRefreshing={isRefreshingContent}
          lastUpdated={lastContentUpdated}
          onRefresh={loadContent}
          status={contentStatus}
        />
        <HomeHeader
          categoryContent={contentData.categoryContent}
          i18nLanguage={i18n.language}
          mediaItems={contentData.mediaItems}
          onOpenDrawer={openDrawer}
          onOpenPage={openPage}
          onSearchSelect={selectSearchSuggestion}
          t={t}
        />
        <ShortcutList onOpenCategory={openCategory} t={t} />
        <FlatList
          horizontal
          data={dynamicCategories}
          keyExtractor={(item) => item.id}
          renderItem={({ item }) => (
            <TouchableOpacity
              style={styles.dynamicCategoryChip}
              onPress={() => openCategory(item.id)}
            >
              <Text style={styles.dynamicCategoryTitle}>{item.title}</Text>
              <Text style={styles.dynamicCategoryCount}>
                {getCategoryItemCount(item.id)} items
              </Text>
            </TouchableOpacity>
          )}
          showsHorizontalScrollIndicator={false}
          contentContainerStyle={styles.dynamicCategoryList}
        />
        <HeroBanner onOpenCategory={openCategory} t={t} />
        <MediaTypeTabs
          activeType={activeType}
          onChangeType={setActiveType}
          t={t}
        />
        <FeatureGrid onOpenCategory={openCategory} t={t} />
        <Text style={styles.sectionTitle}>
          {t("trending")} {t(`mediaType_${activeType}`)}
        </Text>
      </>
    ),
    [
      activeType,
      contentData.categoryContent,
      dynamicCategories,
      contentData.mediaItems,
      getCategoryItemCount,
      i18n.language,
      openCategory,
      openDrawer,
      openPage,
      selectSearchSuggestion,
      t,
    ],
  );

  const renderHomeFooter = useCallback(
    () => <PremiumCard onOpenPage={() => setIsSubscriptionVisible(true)} t={t} />,
    [t],
  );

  useEffect(() => {
    const timer = setTimeout(() => setAppStep("language"), 1400);

    return () => clearTimeout(timer);
  }, []);

  useEffect(() => {
    stepAnim.setValue(0);

    Animated.timing(stepAnim, {
      toValue: 1,

      duration: 260,

      easing: Easing.out(Easing.ease),

      useNativeDriver: true,
    }).start();
  }, [appStep, stepAnim]);

  if (appStep === "splash") {
    return (
      <Animated.View
        style={[styles.stepAnimatedWrap, getStepAnimationStyle(stepAnim)]}
      >
        <SplashScreen />
      </Animated.View>
    );
  }

  if (appStep === "language") {
    return (
      <Animated.View
        style={[styles.stepAnimatedWrap, getStepAnimationStyle(stepAnim)]}
      >
        <LanguageScreen
          selectedLanguage={selectedLanguage}
          onSelectLanguage={handleSelectLanguage}
        />
      </Animated.View>
    );
  }

  if (selectedPage) {
    return (
      <>
        <AccountScreen
          onClearDownloads={clearDownloads}
          downloads={downloads}
          favorites={favorites}
          onBack={() => setSelectedPage("")}
          onOpenCategory={(categoryId) => {
            setSelectedPage("");
            setSelectedCategoryId(categoryId);
          }}
          onToggleSetting={toggleSetting}
          onToggleFavorite={toggleFavorite}
          page={selectedPage}
          phoneUser={phoneUser}
          settings={settings}
          subscription={subscription}
        />
        <BottomTabs activeTab={activeTab} onChangeTab={changeTab} />
        <Snackbar
          visible={Boolean(snackbarMessage)}
          onDismiss={() => setSnackbarMessage("")}
          duration={2800}
          style={styles.appSnackbar}
        >
          {snackbarMessage}
        </Snackbar>
      </>
    );
  }

  if (activeTab === "categories") {
    return (
      <>
        <CategoriesScreen
          categories={dynamicCategories}
          getCategoryItemCount={getCategoryItemCount}
          onBack={() => changeTab("home")}
          onOpenCategory={openCategory}
        />
        <BottomTabs activeTab={activeTab} onChangeTab={changeTab} />
      </>
    );
  }

  if (activeTab === "downloads" || activeTab === "profile") {
    return (
      <>
        <AccountScreen
          onClearDownloads={clearDownloads}
          downloads={downloads}
          favorites={favorites}
          onBack={() => changeTab("home")}
          onOpenCategory={(categoryId) => {
            changeTab("home");
            setSelectedCategoryId(categoryId);
          }}
          onToggleSetting={toggleSetting}
          onToggleFavorite={toggleFavorite}
          page={activeTab}
          phoneUser={phoneUser}
          settings={settings}
          subscription={subscription}
        />
        <BottomTabs activeTab={activeTab} onChangeTab={changeTab} />
      </>
    );
  }

  if (selectedCategoryId) {
    return (
      <>
        <CategoryScreen
          category={selectedCategory}
          categoryId={selectedCategoryId}
          favoriteIds={favoriteIds}
          onBack={() => setSelectedCategoryId("")}
          autoPlayPreviews={settings.autoPlayPreviews}
          onProtectedAction={requestProtectedAction}
          onToggleFavorite={toggleFavorite}
        />
        <PhoneOtpModal
          onClose={closeOtp}
          onVerified={completePhoneLogin}
          t={t}
          visible={isOtpVisible}
        />
        <SubscriptionModal
          freeLimit={FREE_WALLPAPER_DOWNLOAD_LIMIT}
          onClose={closeSubscription}
          onSubscribed={completeSubscription}
          remainingFree={remainingFreeWallpaperDownloads}
          visible={isSubscriptionVisible}
        />
      </>
    );
  }

  return (
    <SafeAreaView edges={["top", "left", "right"]} style={styles.container}>
      <DrawerMenu
        drawerX={drawerX}
        isOpen={isDrawerOpen}
        onClose={closeDrawer}
        onOpenPage={openPage}
        t={t}
      />

      <FlatList
        data={visibleItems}
        keyExtractor={(item) => item.id}
        renderItem={renderMediaItem}
        ListHeaderComponent={homeHeader}
        ListFooterComponent={renderHomeFooter}
        contentContainerStyle={styles.scrollContent}
        keyboardShouldPersistTaps="handled"
        initialNumToRender={8}
        maxToRenderPerBatch={8}
        removeClippedSubviews
        updateCellsBatchingPeriod={50}
        windowSize={7}
        refreshControl={
          <RefreshControl
            refreshing={isRefreshingContent}
            onRefresh={loadContent}
            tintColor="#C2410C"
            colors={["#C2410C"]}
          />
        }
      />

      {showNotificationPrompt && (
        <NotificationPrompt onDismiss={hideNotificationPrompt} t={t} />
      )}

      <PhoneOtpModal
        onClose={closeOtp}
        onVerified={completePhoneLogin}
        t={t}
        visible={isOtpVisible}
      />

      <SubscriptionModal
        freeLimit={FREE_WALLPAPER_DOWNLOAD_LIMIT}
        onClose={closeSubscription}
        onSubscribed={completeSubscription}
        remainingFree={remainingFreeWallpaperDownloads}
        visible={isSubscriptionVisible}
      />

      <BottomTabs activeTab={activeTab} onChangeTab={changeTab} />

      <Snackbar
        visible={Boolean(snackbarMessage)}
        onDismiss={() => setSnackbarMessage("")}
        duration={2800}
        style={styles.appSnackbar}
      >
        {snackbarMessage}
      </Snackbar>

      <StatusBar style="dark" />
    </SafeAreaView>
  );
}
