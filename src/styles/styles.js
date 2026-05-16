import { StyleSheet } from "react-native";

export const styles = StyleSheet.create({
  stepAnimatedWrap: {
    flex: 1,
  },

  container: {
    flex: 1,

    backgroundColor: "#F3F4F6",
  },

  scrollContent: {
    paddingHorizontal: 16,

    paddingBottom: 36,

    paddingTop: 12,
  },

  topBar: {
    flexDirection: "row",

    justifyContent: "space-between",

    alignItems: "center",

    marginTop: 8,
  },

  avatar: {
    backgroundColor: "#C084FC",
  },

  avatarLabel: {
    color: "#FFFFFF",

    fontWeight: "700",
  },

  topActions: {
    flexDirection: "row",

    alignItems: "center",
  },

  searchWrap: {
    marginTop: 10,
    marginBottom: 16,
    position: "relative",
    zIndex: 20,
  },

  search: {
    backgroundColor: "#FFFFFF",

    borderRadius: 16,

    elevation: 0,
  },

  searchInput: {
    minHeight: 40,
  },

  searchDropdown: {
    position: "absolute",
    top: 58,
    left: 0,
    right: 0,
    backgroundColor: "#FFFFFF",
    borderColor: "#EAECF0",
    borderRadius: 16,
    borderWidth: 1,
    elevation: 8,
    overflow: "hidden",
    zIndex: 30,
  },

  searchSuggestion: {
    alignItems: "center",
    borderBottomColor: "#F2F4F7",
    borderBottomWidth: 1,
    flexDirection: "row",
    gap: 12,
    minHeight: 58,
    paddingHorizontal: 14,
  },

  searchSuggestionIcon: {
    alignItems: "center",
    backgroundColor: "#FFF7ED",
    borderRadius: 12,
    height: 36,
    justifyContent: "center",
    width: 36,
  },

  searchSuggestionIconText: {
    color: "#C2410C",
    fontSize: 13,
    fontWeight: "900",
  },

  searchSuggestionTextWrap: {
    flex: 1,
    minWidth: 0,
  },

  searchSuggestionTitle: {
    color: "#101828",
    fontSize: 14,
    fontWeight: "800",
  },

  searchSuggestionMeta: {
    color: "#667085",
    fontSize: 12,
    marginTop: 2,
  },

  shortcutList: {
    paddingVertical: 8,

    gap: 12,
  },

  shortcutItem: {
    width: 84,

    alignItems: "center",
  },

  shortcutCircle: {
    width: 74,

    height: 74,

    borderRadius: 37,

    alignItems: "center",

    justifyContent: "center",

    marginBottom: 6,
  },

  shortcutEmoji: {
    fontSize: 30,
  },

  shortcutLabel: {
    fontSize: 12,

    color: "#1F2937",

    fontWeight: "700",

    textAlign: "center",
  },

  dynamicCategoryList: {
    gap: 10,
    paddingBottom: 6,
    paddingTop: 4,
  },

  dynamicCategoryChip: {
    backgroundColor: "#FFFFFF",
    borderColor: "#E4E7EC",
    borderRadius: 16,
    borderWidth: 1,
    elevation: 1,
    minWidth: 128,
    paddingHorizontal: 14,
    paddingVertical: 12,
  },

  dynamicCategoryTitle: {
    color: "#101828",
    fontSize: 14,
    fontWeight: "900",
  },

  dynamicCategoryCount: {
    color: "#667085",
    fontSize: 12,
    fontWeight: "700",
    marginTop: 3,
  },

  heroCard: {
    marginTop: 12,

    borderRadius: 24,

    overflow: "hidden",

    backgroundColor: "#0F172A",
  },

  heroImage: {
    width: "100%",

    height: 180,
  },

  heroOverlay: {
    position: "absolute",

    width: "100%",

    height: "100%",

    justifyContent: "flex-end",

    padding: 16,
  },

  heroTitle: {
    color: "#FFFFFF",

    fontSize: 16,

    fontWeight: "700",
  },

  heroSubtitle: {
    color: "#E5E7EB",

    marginTop: 2,
  },

  chips: {
    flexDirection: "row",

    marginTop: 16,

    marginBottom: 12,

    gap: 8,
  },

  chipButton: {
    borderRadius: 20,
  },

  grid: {
    flexDirection: "row",

    flexWrap: "wrap",

    justifyContent: "space-between",

    marginBottom: 8,
  },

  tile: {
    width: "100%",

    minHeight: 108,

    borderRadius: 18,

    marginBottom: 12,

    paddingHorizontal: 8,

    paddingVertical: 12,

    justifyContent: "center",

    alignItems: "center",
  },

  tileWrapper: {
    width: "31.5%",
  },

  tileTitle: {
    color: "#FFFFFF",

    fontWeight: "800",

    fontSize: 20,

    lineHeight: 24,

    textAlign: "center",
  },

  sectionTitle: {
    fontSize: 18,

    fontWeight: "700",

    color: "#111827",

    marginTop: 6,

    marginBottom: 10,
  },

  mediaCard: {
    marginBottom: 14,

    backgroundColor: "#FFFFFF",

    borderRadius: 18,
  },

  mediaContent: {
    flexDirection: "row",

    alignItems: "center",
    gap: 10,
    minHeight: 82,
    paddingHorizontal: 14,
  },

  mediaTextWrap: {
    flex: 1,

    paddingRight: 12,
  },

  mediaTitle: {
    color: "#111827",

    fontWeight: "700",

    fontSize: 16,
    lineHeight: 21,
  },

  mediaMeta: {
    color: "#6B7280",

    fontSize: 14,
    marginTop: 2,
  },

  mediaFavButton: {
    backgroundColor: "#FFF7ED",
    borderColor: "#FED7AA",
    borderRadius: 22,
    borderWidth: 1,
    height: 44,
    margin: 0,
    width: 44,
  },

  mediaDownloadButton: {
    backgroundColor: "#F1E7FF",
    borderRadius: 999,
    minWidth: 112,
  },

  mediaDownloadContent: {
    minHeight: 44,
    paddingHorizontal: 2,
  },

  mediaDownloadLabel: {
    color: "#101828",
    fontSize: 13,
    fontWeight: "800",
  },

  categoryContainer: {
    flex: 1,
    backgroundColor: "#F6F7F9",
  },

  categoryHeader: {
    alignItems: "center",
    backgroundColor: "#FFFFFF",
    borderBottomColor: "#EEF0F3",
    borderBottomWidth: 1,
    flexDirection: "row",
    paddingBottom: 16,
    paddingRight: 16,
    paddingTop: 8,
  },

  categoryHeaderText: {
    flex: 1,
    paddingTop: 0,
  },

  categoryTitle: {
    color: "#101828",
    fontSize: 28,
    fontWeight: "800",
    letterSpacing: 0,
  },

  categoryDescription: {
    color: "#667085",
    fontSize: 14,
    lineHeight: 20,
    marginTop: 3,
  },

  categoryList: {
    paddingHorizontal: 16,
    paddingTop: 18,
    paddingBottom: 32,
  },

  categoryCard: {
    backgroundColor: "#FFFFFF",
    borderRadius: 18,
    elevation: 2,
    marginBottom: 16,
    overflow: "hidden",
  },

  categoryMediaWrap: {
    backgroundColor: "#EEF2F6",
  },

  categoryImage: {
    height: 174,
    width: "100%",
  },

  categoryImageRadius: {
    borderTopLeftRadius: 18,
    borderTopRightRadius: 18,
  },

  categoryImageShade: {
    ...StyleSheet.absoluteFillObject,
    backgroundColor: "rgba(0,0,0,0.04)",
  },

  categoryImageFallback: {
    alignItems: "center",
    backgroundColor: "#FFF7ED",
    height: 120,
    justifyContent: "center",
    width: "100%",
  },

  categoryImageFallbackText: {
    color: "#C2410C",
    fontSize: 14,
    fontWeight: "800",
    textTransform: "uppercase",
  },

  categoryContent: {
    alignItems: "center",
    flexDirection: "row",
    gap: 12,
    paddingHorizontal: 14,
    paddingVertical: 14,
  },

  categoryItemTextWrap: {
    flex: 1,
    minWidth: 0,
  },

  categoryItemTitle: {
    color: "#101828",
    fontSize: 17,
    fontWeight: "800",
    lineHeight: 22,
  },

  categoryItemSubtitle: {
    color: "#667085",
    fontSize: 14,
    lineHeight: 19,
    marginTop: 3,
  },

  categoryActionButton: {
    backgroundColor: "#C2410C",
    borderRadius: 999,
    minWidth: 104,
  },

  categoryActionContent: {
    minHeight: 44,
    paddingHorizontal: 4,
  },

  categoryActionLabel: {
    color: "#FFFFFF",
    fontSize: 14,
    fontWeight: "800",
  },

  categoryFavButton: {
    backgroundColor: "#FFF7ED",
    borderRadius: 22,
    margin: 0,
  },

  audioCard: {
    backgroundColor: "#FFFFFF",
    borderRadius: 16,
    elevation: 2,
    marginBottom: 12,
  },

  audioRow: {
    alignItems: "center",
    flexDirection: "row",
    gap: 12,
    minHeight: 92,
    paddingHorizontal: 12,
    paddingVertical: 12,
  },

  audioPlayButton: {
    alignItems: "center",
    backgroundColor: "#C2410C",
    borderRadius: 24,
    height: 48,
    justifyContent: "center",
    width: 48,
  },

  audioPlayIcon: {
    margin: 0,
  },

  audioMain: {
    flex: 1,
    minWidth: 0,
  },

  audioTitleRow: {
    alignItems: "flex-start",
    flexDirection: "row",
    gap: 10,
  },

  audioTextWrap: {
    flex: 1,
    minWidth: 0,
  },

  audioTitle: {
    color: "#101828",
    fontSize: 15,
    fontWeight: "800",
    lineHeight: 20,
  },

  audioSubtitle: {
    color: "#667085",
    fontSize: 12,
    lineHeight: 17,
    marginTop: 2,
  },

  audioDuration: {
    color: "#667085",
    fontSize: 12,
    fontWeight: "700",
    marginTop: 2,
  },

  audioProgressTrack: {
    backgroundColor: "#EAECF0",
    borderRadius: 999,
    height: 6,
    marginTop: 14,
    overflow: "hidden",
    position: "relative",
  },

  audioProgressFill: {
    backgroundColor: "#C2410C",
    borderRadius: 999,
    bottom: 0,
    left: 0,
    position: "absolute",
    top: 0,
  },

  audioWaveWrap: {
    alignItems: "center",
    bottom: -9,
    flexDirection: "row",
    gap: 3,
    left: 0,
    position: "absolute",
  },

  audioWaveBar: {
    backgroundColor: "#C2410C",
    borderRadius: 999,
    height: 22,
    width: 3,
  },

  audioDownloadButton: {
    backgroundColor: "#FFF7ED",
    borderRadius: 22,
    margin: 0,
  },

  accountContainer: {
    flex: 1,
    backgroundColor: "#F6F7F9",
  },

  accountHeader: {
    alignItems: "center",
    backgroundColor: "#FFFFFF",
    borderBottomColor: "#EEF0F3",
    borderBottomWidth: 1,
    flexDirection: "row",
    paddingBottom: 16,
    paddingRight: 16,
    paddingTop: 8,
  },

  accountHeaderText: {
    flex: 1,
    minWidth: 0,
  },

  accountTitle: {
    color: "#101828",
    fontSize: 30,
    fontWeight: "900",
    letterSpacing: 0,
    lineHeight: 36,
  },

  accountSubtitle: {
    color: "#667085",
    fontSize: 13,
    fontWeight: "700",
    marginTop: 2,
  },

  accountContent: {
    padding: 16,
  },

  profileHeroCard: {
    backgroundColor: "#101828",
    borderRadius: 18,
    marginBottom: 16,
  },

  profileAvatar: {
    alignItems: "center",
    backgroundColor: "#C084FC",
    borderRadius: 28,
    height: 56,
    justifyContent: "center",
    width: 56,
  },

  profileAvatarText: {
    color: "#FFFFFF",
    fontSize: 26,
    fontWeight: "900",
  },

  profileName: {
    color: "#FFFFFF",
    fontSize: 22,
    fontWeight: "900",
    marginTop: 14,
  },

  profilePhone: {
    color: "#CBD5E1",
    fontSize: 14,
    marginTop: 4,
  },

  accountList: {
    padding: 16,
    paddingBottom: 34,
  },

  accountListCard: {
    backgroundColor: "#FFFFFF",
    borderRadius: 16,
    marginBottom: 12,
  },

  accountListContent: {
    alignItems: "center",
    flexDirection: "row",
    gap: 12,
  },

  accountItemIcon: {
    alignItems: "center",
    backgroundColor: "#FFF7ED",
    borderRadius: 14,
    height: 44,
    justifyContent: "center",
    width: 44,
  },

  accountItemIconText: {
    color: "#C2410C",
    fontSize: 14,
    fontWeight: "900",
  },

  accountItemTextWrap: {
    flex: 1,
    minWidth: 0,
  },

  accountItemTitle: {
    color: "#101828",
    fontSize: 15,
    fontWeight: "900",
  },

  accountItemMeta: {
    color: "#667085",
    fontSize: 12,
    marginTop: 3,
  },

  emptyState: {
    alignItems: "center",
    paddingHorizontal: 28,
    paddingTop: 140,
  },

  emptyIcon: {
    alignItems: "center",
    backgroundColor: "#FFF7ED",
    borderRadius: 34,
    height: 68,
    justifyContent: "center",
    marginBottom: 18,
    width: 68,
  },

  emptyIconText: {
    color: "#C2410C",
    fontSize: 26,
    fontWeight: "900",
  },

  emptyTitle: {
    color: "#101828",
    fontSize: 19,
    fontWeight: "900",
    textAlign: "center",
  },

  emptyText: {
    color: "#667085",
    fontSize: 14,
    lineHeight: 20,
    marginTop: 8,
    textAlign: "center",
  },

  settingsRow: {
    alignItems: "center",
    backgroundColor: "#FFFFFF",
    borderRadius: 16,
    flexDirection: "row",
    justifyContent: "space-between",
    marginBottom: 12,
    paddingHorizontal: 16,
    paddingVertical: 14,
  },

  settingsLabel: {
    color: "#101828",
    fontSize: 15,
    fontWeight: "900",
  },

  settingsValue: {
    color: "#667085",
    fontSize: 14,
    fontWeight: "700",
  },

  settingsHint: {
    color: "#667085",
    fontSize: 12,
    marginTop: 3,
  },

  settingsButton: {
    borderColor: "#C2410C",
    borderRadius: 14,
    marginTop: 8,
  },

  premiumCard: {
    borderRadius: 20,

    backgroundColor: "#0B1220",

    marginTop: 10,
  },

  premiumTitle: {
    color: "#FBBF24",

    fontSize: 18,

    fontWeight: "800",
  },

  premiumText: {
    color: "#E5E7EB",

    marginTop: 6,

    marginBottom: 12,
  },

  premiumButton: {
    borderRadius: 12,
  },

  drawerOverlay: {
    ...StyleSheet.absoluteFillObject,

    backgroundColor: "rgba(2, 6, 23, 0.3)",

    zIndex: 5,
  },

  drawer: {
    position: "absolute",

    top: 0,

    left: 0,

    bottom: 0,

    width: 280,

    backgroundColor: "#111827",

    paddingTop: 60,

    paddingHorizontal: 18,

    zIndex: 6,
  },

  drawerTitle: {
    color: "#FFFFFF",

    fontSize: 22,

    fontWeight: "700",

    marginBottom: 16,
  },

  drawerItem: {
    borderBottomColor: "#1F2937",

    borderBottomWidth: 1,

    paddingVertical: 14,
  },

  drawerItemText: {
    color: "#E5E7EB",

    fontSize: 16,

    fontWeight: "600",
  },

  devContainer: {
    flex: 1,

    backgroundColor: "#0B1220",

    paddingTop: 14,
  },

  devHeader: {
    alignItems: "flex-start",
  },

  devContent: {
    flex: 1,

    justifyContent: "center",

    alignItems: "center",

    paddingHorizontal: 20,
  },

  devTitle: {
    color: "#F9FAFB",

    fontSize: 24,

    fontWeight: "700",

    textAlign: "center",
  },

  devText: {
    color: "#FBBF24",

    marginTop: 10,

    fontSize: 18,

    fontWeight: "700",
  },

  splashContainer: {
    flex: 1,

    backgroundColor: "#000000",

    justifyContent: "space-between",

    paddingHorizontal: 26,

    paddingVertical: 42,
  },

  splashCenter: {
    marginTop: 140,

    alignItems: "center",
  },

  splashLogoWrap: {
    width: 84,

    height: 84,

    borderRadius: 14,

    backgroundColor: "#F97316",

    justifyContent: "center",

    alignItems: "center",
  },

  splashLogo: {
    color: "#FFFFFF",

    fontSize: 42,

    fontWeight: "700",
  },

  splashTitle: {
    color: "#FFFFFF",

    fontSize: 40,

    fontWeight: "700",

    marginTop: 18,
  },

  splashSubtitle: {
    color: "#E5E7EB",

    fontSize: 17,

    textAlign: "center",

    marginTop: 14,

    lineHeight: 25,
  },

  splashLoaderTrack: {
    width: "100%",

    backgroundColor: "#FFFFFF",

    borderRadius: 999,

    height: 48,

    justifyContent: "center",

    alignItems: "center",
  },

  languageContainer: {
    flex: 1,

    backgroundColor: "#000000",

    paddingHorizontal: 20,

    paddingTop: 20,
  },

  languageClose: {
    width: 36,

    height: 36,

    justifyContent: "center",

    alignItems: "center",
  },

  languageCloseText: {
    color: "#FFFFFF",

    fontSize: 26,
  },

  langTopLogo: {
    alignSelf: "center",

    width: 74,

    height: 74,

    borderRadius: 12,

    marginTop: 20,

    marginBottom: 18,

    backgroundColor: "#F97316",

    alignItems: "center",

    justifyContent: "center",
  },

  languageTitle: {
    color: "#FFFFFF",

    fontSize: 44,

    textAlign: "center",

    fontWeight: "600",

    marginBottom: 20,
  },

  languageGrid: {
    flexDirection: "row",

    flexWrap: "wrap",

    justifyContent: "space-between",
  },

  languageTile: {
    width: "48%",
    borderWidth: 2,
    borderColor: "#E5E7EB",
    borderRadius: 12,
    paddingVertical: 16,

    alignItems: "center",
    marginBottom: 14,
  },
  languageTileSelected: {
    borderColor: "#F97316",
    backgroundColor: "#24130A",
  },
  languageMain: {
    color: "#FFFFFF",

    fontSize: 18,

    fontWeight: "600",
  },

  languageNative: {
    color: "#E5E7EB",

    fontSize: 16,

    marginTop: 4,
  },

  notifyOverlay: {
    ...StyleSheet.absoluteFillObject,

    backgroundColor: "rgba(17, 24, 39, 0.5)",

    justifyContent: "flex-end",

    padding: 18,
  },

  notifyCard: {
    backgroundColor: "#1F2937",

    borderRadius: 18,

    overflow: "hidden",
  },

  notifyTitle: {
    color: "#FFFFFF",

    fontSize: 19,

    fontWeight: "600",

    textAlign: "center",

    paddingVertical: 24,

    paddingHorizontal: 16,
  },

  notifyActions: {
    borderTopWidth: 1,

    borderTopColor: "#374151",
  },

  notifyActionText: {
    textAlign: "center",

    color: "#2563EB",

    fontSize: 20,

    paddingVertical: 16,

    borderTopWidth: 1,

    borderTopColor: "#374151",
  },

  otpOverlay: {
    flex: 1,
    backgroundColor: "rgba(15, 23, 42, 0.58)",
    justifyContent: "center",
    paddingHorizontal: 20,
  },

  otpCard: {
    backgroundColor: "#FFFFFF",
    borderRadius: 24,
    padding: 20,
  },

  otpHeader: {
    alignItems: "center",
    flexDirection: "row",
    justifyContent: "space-between",
    marginBottom: 12,
  },

  otpIconWrap: {
    alignItems: "center",
    backgroundColor: "#FFF7ED",
    borderRadius: 18,
    height: 44,
    justifyContent: "center",
    width: 44,
  },

  otpIconText: {
    color: "#C2410C",
    fontSize: 16,
    fontWeight: "900",
  },

  otpCloseButton: {
    margin: 0,
  },

  otpTitle: {
    color: "#101828",
    fontSize: 24,
    fontWeight: "800",
    letterSpacing: 0,
  },

  otpSubtitle: {
    color: "#667085",
    fontSize: 14,
    lineHeight: 20,
    marginTop: 6,
    marginBottom: 16,
  },

  otpInput: {
    backgroundColor: "#F9FAFB",
    borderWidth: 1,
    borderColor: "#D0D5DD",
    borderRadius: 14,
    color: "#101828",
    fontSize: 16,
    minHeight: 54,
    marginTop: 10,
    paddingHorizontal: 16,
  },

  otpDevHint: {
    color: "#C2410C",
    fontSize: 13,
    fontWeight: "700",
    marginTop: 8,
  },

  otpError: {
    color: "#DC2626",
    fontSize: 13,
    marginTop: 10,
  },

  otpActions: {
    flexDirection: "row",
    justifyContent: "flex-end",
    gap: 12,
    marginTop: 20,
  },

  otpPrimaryButton: {
    alignItems: "center",
    backgroundColor: "#C2410C",
    borderRadius: 14,
    justifyContent: "center",
    minHeight: 48,
    minWidth: 116,
    paddingHorizontal: 18,
  },

  otpPaperButton: {
    borderColor: "#D0D5DD",
    borderRadius: 14,
    justifyContent: "center",
    minHeight: 48,
  },

  otpButtonDisabled: {
    opacity: 0.45,
  },

  otpPrimaryText: {
    color: "#FFFFFF",
    fontWeight: "800",
    textAlign: "center",
  },

  otpSecondaryText: {
    color: "#344054",
    fontWeight: "800",
    textAlign: "center",
  },

  errorContainer: {
    flex: 1,

    backgroundColor: "#0B1220",

    justifyContent: "center",

    paddingHorizontal: 20,
  },

  errorCard: {
    backgroundColor: "#FFFFFF",

    borderRadius: 16,

    padding: 20,
  },

  errorTitle: {
    color: "#111827",

    fontSize: 22,

    fontWeight: "800",
  },

  errorText: {
    color: "#4B5563",

    fontSize: 15,

    lineHeight: 22,

    marginTop: 8,
  },

  errorButton: {
    alignSelf: "flex-start",

    backgroundColor: "#7C3AED",

    borderRadius: 12,

    marginTop: 18,

    paddingHorizontal: 18,

    paddingVertical: 12,
  },

  errorButtonText: {
    color: "#FFFFFF",

    fontWeight: "800",
  },
});
