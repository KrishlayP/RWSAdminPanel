import { memo } from "react";
import { Text, TouchableOpacity, View } from "react-native";
import { IconButton } from "react-native-paper";

import { styles } from "../styles/styles";

const TABS = [
  { id: "home", icon: "home-variant", label: "Home" },
  { id: "categories", icon: "view-grid-outline", label: "Categories" },
  { id: "downloads", icon: "download-circle-outline", label: "Downloads" },
  { id: "profile", icon: "account-circle-outline", label: "Profile" },
];

function BottomTabs({ activeTab, onChangeTab }) {
  return (
    <View style={styles.bottomTabs}>
      {TABS.map((tab) => {
        const isActive = activeTab === tab.id;

        return (
          <TouchableOpacity
            key={tab.id}
            activeOpacity={0.82}
            onPress={() => onChangeTab(tab.id)}
            style={[styles.bottomTab, isActive && styles.bottomTabActive]}
          >
            <IconButton
              icon={tab.icon}
              iconColor={isActive ? "#FFFFFF" : "#667085"}
              size={21}
              style={styles.bottomTabIcon}
            />
            <Text
              numberOfLines={1}
              style={[
                styles.bottomTabLabel,
                isActive && styles.bottomTabLabelActive,
              ]}
            >
              {tab.label}
            </Text>
          </TouchableOpacity>
        );
      })}
    </View>
  );
}

export default memo(BottomTabs);
