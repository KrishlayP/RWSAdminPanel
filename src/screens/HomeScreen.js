import { StatusBar } from "expo-status-bar";
import { useCallback, useEffect, useMemo, useRef, useState } from "react";
import {
  Animated,
  Easing,
  FlatList,
  Text,
  TouchableOpacity,
} from "react-native";
import { useTranslation } from "react-i18next";
import { SafeAreaView } from "react-native-safe-area-context";

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
import { CATEGORY_CONTENT, MEDIA_ITEMS } from "../data/appData";
import { fetchRemoteContent } from "../services/contentService";
import { loadUserLibrary, saveUserLibrary } from "../services/localStore";
import { styles } from "../styles/styles";
import { getStepAnimationStyle } from "../utils/animations";
import AccountScreen from "./AccountScreen";
import CategoryScreen from "./CategoryScreen";
import LanguageScreen from "./LanguageScreen";
import SplashScreen from "./SplashScreen";

export default function HomeScreen() {
  const [activeType, setActiveType] = useState("wallpaper");
  const [selectedPage, setSelectedPage] = useState("");
  const [selectedCategoryId, setSelectedCategoryId] = useState("");
  const [isDrawerOpen, setIsDrawerOpen] = useState(false);
  const [appStep, setAppStep] = useState("splash");
  const [showNotificationPrompt, setShowNotificationPrompt] = useState(true);
  const [phoneUser, setPhoneUser] = useState(null);
  const [isOtpVisible, setIsOtpVisible] = useState(false);
  const [favorites, setFavorites] = useState([]);
  const [downloads, setDownloads] = useState([]);
  const [settings, setSettings] = useState({
    autoPlayPreviews: true,
    dailyReminders: true,
  });
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

  useEffect(() => {
    let isMounted = true;

    fetchRemoteContent()
      .then((remoteContent) => {
        if (!isMounted || !remoteContent) return;

        setContentData({
          categories: remoteContent.categories || [],
          categoryContent: remoteContent.categoryContent || CATEGORY_CONTENT,
          mediaItems: remoteContent.mediaItems || MEDIA_ITEMS,
        });
      })
      .catch(() => {
        if (!isMounted) return;

        setContentData({
          categories: Object.entries(CATEGORY_CONTENT).map(([id, category]) => ({
            id,
            title: category.title,
            description: category.description,
          })),
          categoryContent: CATEGORY_CONTENT,
          mediaItems: MEDIA_ITEMS,
        });
      });

    return () => {
      isMounted = false;
    };
  }, []);

  useEffect(() => {
    let isMounted = true;

    loadUserLibrary()
      .then((library) => {
        if (!isMounted) return;

        setFavorites(library.favorites.map(normalizeLibraryItem).filter(Boolean));
        setDownloads(library.downloads.map(normalizeLibraryItem).filter(Boolean));
        setPhoneUser(library.phoneUser);
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
      settings,
    });
  }, [downloads, favorites, isLibraryReady, phoneUser, settings]);

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
      setSelectedCategoryId(categoryId);
    },
    [closeDrawer],
  );

  const requestProtectedAction = useCallback(
    (actionTitle, item = null) => {
      const completeDownload = () => {
        if (item) {
          setDownloads((current) => {
            const normalizedItem = normalizeLibraryItem(item);

            if (!normalizedItem) {
              return current;
            }

            if (current.some((download) => download.id === normalizedItem.id)) {
              return current;
            }

            return [{ ...normalizedItem, downloadedAt: Date.now() }, ...current];
          });
        }

        setSelectedPage("downloads");
      };

      if (phoneUser) {
        completeDownload();
        return;
      }

      pendingProtectedActionRef.current = completeDownload;
      setIsOtpVisible(true);
    },
    [normalizeLibraryItem, phoneUser],
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
    () => <PremiumCard onOpenPage={openPage} t={t} />,
    [openPage, t],
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
      />
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

      <StatusBar style="dark" />
    </SafeAreaView>
  );
}
