import { memo, useEffect, useMemo, useRef, useState } from "react";
import { Animated, Linking, Modal, Text, TouchableOpacity, View } from "react-native";
import { Button, IconButton } from "react-native-paper";

import { styles } from "../styles/styles";

const PLAN_AMOUNT = process.env.EXPO_PUBLIC_SUBSCRIPTION_AMOUNT || "49";
const UPI_ID = process.env.EXPO_PUBLIC_UPI_ID || "merchant@upi";
const UPI_NAME = process.env.EXPO_PUBLIC_UPI_NAME || "Sanatan App";

function SubscriptionModal({
  freeLimit = 2,
  onClose,
  onSubscribed,
  remainingFree = 0,
  visible,
}) {
  const modalAnim = useRef(new Animated.Value(0)).current;
  const [paymentError, setPaymentError] = useState("");
  const upiUrl = useMemo(() => {
    const note = `Sanatan premium subscription`;
    const params = new URLSearchParams({
      pa: UPI_ID,
      pn: UPI_NAME,
      am: PLAN_AMOUNT,
      cu: "INR",
      tn: note,
    });

    return `upi://pay?${params.toString()}`;
  }, []);

  useEffect(() => {
    if (visible) {
      setPaymentError("");
      Animated.spring(modalAnim, {
        toValue: 1,
        friction: 8,
        tension: 90,
        useNativeDriver: true,
      }).start();
    } else {
      modalAnim.setValue(0);
      setPaymentError("");
    }
  }, [modalAnim, visible]);

  const cardAnimatedStyle = {
    opacity: modalAnim,
    transform: [
      {
        translateY: modalAnim.interpolate({
          inputRange: [0, 1],
          outputRange: [28, 0],
        }),
      },
      {
        scale: modalAnim.interpolate({
          inputRange: [0, 1],
          outputRange: [0.92, 1],
        }),
      },
    ],
  };

  const overlayAnimatedStyle = {
    opacity: modalAnim.interpolate({
      inputRange: [0, 1],
      outputRange: [0, 1],
    }),
  };

  const startUpiPayment = async () => {
    try {
      setPaymentError("");
      const canOpen = await Linking.canOpenURL(upiUrl);

      if (!canOpen) {
        setPaymentError("No UPI app found on this phone.");
        return;
      }

      await Linking.openURL(upiUrl);
    } catch {
      setPaymentError("Could not open UPI payment. Please try again.");
    }
  };

  return (
    <Modal
      transparent
      visible={visible}
      animationType="fade"
      onRequestClose={onClose}
    >
      <Animated.View style={[styles.subscriptionOverlay, overlayAnimatedStyle]}>
        <Animated.View style={[styles.subscriptionCard, cardAnimatedStyle]}>
          <View style={styles.subscriptionHeader}>
            <View style={styles.subscriptionIconWrap}>
              <Text style={styles.subscriptionIconText}>UPI</Text>
            </View>
            <IconButton
              icon="close"
              iconColor="#64748B"
              size={20}
              onPress={onClose}
              style={styles.otpCloseButton}
            />
          </View>

          <Text style={styles.subscriptionTitle}>Subscribe to continue</Text>
          <Text style={styles.subscriptionSubtitle}>
            You get {freeLimit} free wallpaper downloads. Subscribe for unlimited
            wallpaper downloads.
          </Text>

          <View style={styles.subscriptionUsageRow}>
            <Text style={styles.subscriptionUsageLabel}>Free downloads left</Text>
            <Text style={styles.subscriptionUsageValue}>{remainingFree}</Text>
          </View>

          <View style={styles.subscriptionPlanBox}>
            <View>
              <Text style={styles.subscriptionPlanTitle}>Premium access</Text>
              <Text style={styles.subscriptionPlanMeta}>UPI payment</Text>
            </View>
            <Text style={styles.subscriptionPrice}>Rs. {PLAN_AMOUNT}</Text>
          </View>

          {paymentError ? (
            <Text style={styles.subscriptionError}>{paymentError}</Text>
          ) : null}

          <TouchableOpacity
            activeOpacity={0.9}
            style={styles.subscriptionPrimaryButton}
            onPress={startUpiPayment}
          >
            <Text style={styles.subscriptionPrimaryText}>Pay with UPI</Text>
          </TouchableOpacity>

          <Button
            mode="text"
            textColor="#C2410C"
            onPress={onSubscribed}
            style={styles.subscriptionConfirmButton}
          >
            I have paid
          </Button>
        </Animated.View>
      </Animated.View>
    </Modal>
  );
}

export default memo(SubscriptionModal);
