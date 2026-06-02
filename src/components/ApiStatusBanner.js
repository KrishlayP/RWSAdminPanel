import { memo } from "react";
import { Text, TouchableOpacity, View } from "react-native";
import { IconButton } from "react-native-paper";

import { styles } from "../styles/styles";

function ApiStatusBanner({ error, isRefreshing, lastUpdated, onRefresh, status }) {
  const isLive = status === "live";
  const title = isLive ? "Live content synced" : "Using offline sample content";
  const meta = isLive && lastUpdated
    ? `Updated ${lastUpdated.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })}`
    : error || "Pull latest data from admin panel.";

  return (
    <View style={[styles.apiStatusBanner, !isLive && styles.apiStatusWarning]}>
      <View style={styles.apiStatusTextWrap}>
        <Text style={styles.apiStatusTitle}>{title}</Text>
        <Text style={styles.apiStatusMeta}>{meta}</Text>
      </View>
      <TouchableOpacity
        activeOpacity={0.82}
        disabled={isRefreshing}
        onPress={onRefresh}
        style={styles.apiStatusButton}
      >
        <IconButton
          icon={isRefreshing ? "loading" : "refresh"}
          iconColor="#101828"
          size={20}
          style={styles.apiStatusIcon}
        />
      </TouchableOpacity>
    </View>
  );
}

export default memo(ApiStatusBanner);
