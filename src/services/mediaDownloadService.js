import * as FileSystem from "expo-file-system";
import * as MediaLibrary from "expo-media-library";
import * as Sharing from "expo-sharing";

const FALLBACK_EXTENSIONS = {
  audio: "mp3",
  book: "pdf",
  image: "jpg",
  ringtone: "mp3",
  song: "mp3",
  video: "mp4",
  wallpaper: "jpg",
};

function getSourceUrl(item) {
  if (!item) return "";

  if (item.type === "image" || item.type === "wallpaper") {
    return item.image || item.mediaUrl || "";
  }

  return item.mediaUrl || "";
}

function getFileExtension(url, type) {
  const cleanUrl = String(url || "").split("?")[0];
  const match = cleanUrl.match(/\.([a-z0-9]{2,5})$/i);

  return (match?.[1] || FALLBACK_EXTENSIONS[type] || "bin").toLowerCase();
}

function safeFileName(value) {
  return String(value || "download")
    .trim()
    .replace(/[^a-z0-9-_]+/gi, "-")
    .replace(/^-+|-+$/g, "")
    .slice(0, 48) || "download";
}

export async function downloadMediaItem(item) {
  const sourceUrl = getSourceUrl(item);

  if (!sourceUrl) {
    throw new Error("No downloadable file is attached to this item.");
  }

  const extension = getFileExtension(sourceUrl, item.type);
  const fileName = `${safeFileName(item.title || item.id)}-${Date.now()}.${extension}`;
  const localUri = `${FileSystem.documentDirectory}${fileName}`;
  const result = await FileSystem.downloadAsync(sourceUrl, localUri);

  if (result.status && result.status >= 400) {
    throw new Error("Download failed. Please try again.");
  }

  if (item.type === "image" || item.type === "wallpaper") {
    const permission = await MediaLibrary.requestPermissionsAsync();

    if (!permission.granted) {
      throw new Error("Gallery permission is required to save wallpapers.");
    }

    const asset = await MediaLibrary.createAssetAsync(result.uri);

    return {
      action: "saved",
      localUri: result.uri,
      assetUri: asset.uri,
      message: "Wallpaper saved to gallery.",
    };
  }

  if (await Sharing.isAvailableAsync()) {
    await Sharing.shareAsync(result.uri);

    return {
      action: "shared",
      localUri: result.uri,
      message: "File downloaded and ready to share.",
    };
  }

  return {
    action: "downloaded",
    localUri: result.uri,
    message: "File downloaded.",
  };
}
