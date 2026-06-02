import { useMemo } from "react";
import { FlatList, Text, View } from "react-native";
import { Button, Card, IconButton, Switch } from "react-native-paper";
import { SafeAreaView } from "react-native-safe-area-context";

import { styles } from "../styles/styles";

const PAGE_TITLES = {
  profile: "My Profile",
  downloads: "Downloads",
  favorites: "Favorites",
  settings: "Settings",
};

function getItemCategoryId(item) {
  return item?.categoryId || item?.category_id || "";
}

export default function AccountScreen({
  onClearDownloads,
  downloads,
  favorites,
  onBack,
  onOpenCategory,
  onToggleSetting,
  onToggleFavorite,
  page,
  phoneUser,
  settings,
}) {
  const title = PAGE_TITLES[page] || "Account";
  const data = page === "downloads" ? downloads : favorites;

  const renderListItem = ({ item }) => (
    <Card style={styles.accountListCard} mode="elevated">
      <Card.Content style={styles.accountListContent}>
        <View style={styles.accountItemIcon}>
          <Text style={styles.accountItemIconText}>
            {item.type === "image" || item.type === "wallpaper"
              ? "W"
              : item.type === "audio" || item.type === "song"
                ? "A"
                : "M"}
          </Text>
        </View>
        <View style={styles.accountItemTextWrap}>
          <Text style={styles.accountItemTitle}>{item.title}</Text>
          <Text style={styles.accountItemMeta}>
            {item.subtitle ||
              item.categoryTitle ||
              getItemCategoryId(item) ||
              item.type ||
              "Saved item"}
          </Text>
        </View>
        {page === "favorites" ? (
          <IconButton
            icon="heart"
            iconColor="#C2410C"
            onPress={() => onToggleFavorite(item)}
          />
        ) : getItemCategoryId(item) ? (
          <IconButton
            icon="arrow-right"
            iconColor="#C2410C"
            onPress={() => onOpenCategory(getItemCategoryId(item))}
          />
        ) : null}
      </Card.Content>
    </Card>
  );

  const profileRows = useMemo(
    () => [
      ["Phone", phoneUser?.phone || "Not verified"],
      ["Plan", "Free"],
      ["Saved items", `${favorites.length}`],
      ["Downloads", `${downloads.length}`],
    ],
    [downloads.length, favorites.length, phoneUser?.phone],
  );

  return (
    <SafeAreaView edges={["top", "left", "right"]} style={styles.accountContainer}>
      <View style={styles.accountHeader}>
        <IconButton icon="arrow-left" iconColor="#101828" onPress={onBack} />
        <View style={styles.accountHeaderText}>
          <Text style={styles.accountTitle}>{title}</Text>
          <Text style={styles.accountSubtitle}>
            {page === "downloads"
              ? `${downloads.length} saved downloads`
              : page === "favorites"
                ? `${favorites.length} favorite items`
                : page === "settings"
                  ? "Preferences and storage"
                  : "Profile and activity"}
          </Text>
        </View>
      </View>

      {page === "profile" ? (
        <View style={styles.accountContent}>
          <Card style={styles.profileHeroCard}>
            <Card.Content>
              <View style={styles.profileAvatar}>
                <Text style={styles.profileAvatarText}>F</Text>
              </View>
              <Text style={styles.profileName}>Sanatan User</Text>
              <Text style={styles.profilePhone}>
                {phoneUser?.phone || "Login with phone to sync activity"}
              </Text>
            </Card.Content>
          </Card>
          {profileRows.map(([label, value]) => (
            <View key={label} style={styles.settingsRow}>
              <Text style={styles.settingsLabel}>{label}</Text>
              <Text style={styles.settingsValue}>{value}</Text>
            </View>
          ))}
        </View>
      ) : null}

      {page === "settings" ? (
        <View style={styles.accountContent}>
          <View style={styles.settingsRow}>
            <View>
              <Text style={styles.settingsLabel}>Daily reminders</Text>
              <Text style={styles.settingsHint}>Bhakti notification prompts</Text>
            </View>
            <Switch
              value={settings.dailyReminders}
              onValueChange={() => onToggleSetting("dailyReminders")}
            />
          </View>
          <View style={styles.settingsRow}>
            <View>
              <Text style={styles.settingsLabel}>Auto play previews</Text>
              <Text style={styles.settingsHint}>Animate audio rows while playing</Text>
            </View>
            <Switch
              value={settings.autoPlayPreviews}
              onValueChange={() => onToggleSetting("autoPlayPreviews")}
            />
          </View>
          <Button
            mode="outlined"
            onPress={onClearDownloads}
            style={styles.settingsButton}
          >
            Clear cached downloads
          </Button>
        </View>
      ) : null}

      {page === "downloads" || page === "favorites" ? (
        <FlatList
          data={data}
          keyExtractor={(item) => `${page}-${item.id}`}
          renderItem={renderListItem}
          ListEmptyComponent={
            <View style={styles.emptyState}>
              <View style={styles.emptyIcon}>
                <Text style={styles.emptyIconText}>
                  {page === "downloads" ? "D" : "F"}
                </Text>
              </View>
              <Text style={styles.emptyTitle}>
                {page === "downloads" ? "No downloads yet" : "No favorites yet"}
              </Text>
              <Text style={styles.emptyText}>
                {page === "downloads"
                  ? "Download any wallpaper, bhajan or ringtone to see it here."
                  : "Tap heart on any item to save it here."}
              </Text>
            </View>
          }
          contentContainerStyle={styles.accountList}
        />
      ) : null}
    </SafeAreaView>
  );
}
