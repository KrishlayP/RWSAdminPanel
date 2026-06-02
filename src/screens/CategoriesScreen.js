import { FlatList, Text, TouchableOpacity, View } from "react-native";
import { IconButton } from "react-native-paper";
import { SafeAreaView } from "react-native-safe-area-context";

import { styles } from "../styles/styles";

export default function CategoriesScreen({
  categories,
  getCategoryItemCount,
  onBack,
  onOpenCategory,
}) {
  return (
    <SafeAreaView edges={["top", "left", "right"]} style={styles.categoryContainer}>
      <View style={styles.categoryHeader}>
        <IconButton icon="arrow-left" iconColor="#111827" onPress={onBack} />
        <View style={styles.categoryHeaderText}>
          <Text style={styles.categoryTitle}>Categories</Text>
          <Text style={styles.categoryDescription}>
            Browse all live sections from the admin panel.
          </Text>
        </View>
      </View>

      <FlatList
        data={categories}
        keyExtractor={(item) => item.id}
        contentContainerStyle={styles.categoryDirectoryList}
        renderItem={({ item }) => (
          <TouchableOpacity
            activeOpacity={0.86}
            style={styles.categoryDirectoryCard}
            onPress={() => onOpenCategory(item.id)}
          >
            <View style={styles.categoryDirectoryIcon}>
              <Text style={styles.categoryDirectoryIconText}>
                {(item.title || item.id || "C").slice(0, 1).toUpperCase()}
              </Text>
            </View>
            <View style={styles.categoryDirectoryText}>
              <Text style={styles.categoryDirectoryTitle}>{item.title}</Text>
              <Text style={styles.categoryDirectoryMeta}>
                {getCategoryItemCount(item.id)} items
              </Text>
            </View>
            <IconButton icon="chevron-right" iconColor="#C2410C" size={24} />
          </TouchableOpacity>
        )}
        ListEmptyComponent={
          <View style={styles.emptyState}>
            <View style={styles.emptyIcon}>
              <Text style={styles.emptyIconText}>C</Text>
            </View>
            <Text style={styles.emptyTitle}>No live categories</Text>
            <Text style={styles.emptyText}>
              Add active categories and media from the admin panel.
            </Text>
          </View>
        }
      />
    </SafeAreaView>
  );
}
