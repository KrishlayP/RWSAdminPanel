import AsyncStorage from "@react-native-async-storage/async-storage";

const STORAGE_KEY = "rwsapp:user-library:v1";

const DEFAULT_LIBRARY = {
  downloads: [],
  favorites: [],
  phoneUser: null,
  subscription: {
    isActive: false,
    activatedAt: null,
  },
  settings: {
    autoPlayPreviews: true,
    dailyReminders: true,
  },
};

export async function loadUserLibrary() {
  const rawValue = await AsyncStorage.getItem(STORAGE_KEY);

  if (!rawValue) {
    return DEFAULT_LIBRARY;
  }

  try {
    const parsed = JSON.parse(rawValue);

    return {
      ...DEFAULT_LIBRARY,
      ...parsed,
      subscription: {
        ...DEFAULT_LIBRARY.subscription,
        ...(parsed.subscription || {}),
      },
      settings: {
        ...DEFAULT_LIBRARY.settings,
        ...(parsed.settings || {}),
      },
    };
  } catch {
    return DEFAULT_LIBRARY;
  }
}

export async function saveUserLibrary(library) {
  await AsyncStorage.setItem(STORAGE_KEY, JSON.stringify(library));
}

export async function clearUserLibrary() {
  await AsyncStorage.removeItem(STORAGE_KEY);
}
