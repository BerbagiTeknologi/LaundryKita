import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useLocalSearchParams, useRouter } from 'expo-router';
import React from 'react';
import { Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');

type OutletItem = {
  title: string;
  icon: keyof typeof MaterialCommunityIcons.glyphMap;
  route?: '/account/outlet/profile' | '/account/outlet/hours' | '/account/outlet/pickup';
};

const SETTINGS: OutletItem[] = [
  { title: 'Edit Profil Outlet', icon: 'storefront-outline', route: '/account/outlet/profile' },
  { title: 'Jam Operasional', icon: 'clock-outline', route: '/account/outlet/hours' },
  { title: 'Jam Antar Jemput', icon: 'clock-fast', route: '/account/outlet/pickup' },
  { title: 'Tarif Ongkir', icon: 'cash-fast' },
  { title: 'Review dari Pelanggan', icon: 'thumb-up-outline' },
  { title: 'Printer & Nota', icon: 'printer-outline' },
];

const FEATURES: OutletItem[] = [
  { title: 'Mode Transaksi', icon: 'credit-card-outline' },
  { title: 'Foto/Bukti Cucian', icon: 'camera-outline' },
];

export default function OutletManageScreen() {
  const router = useRouter();
  const params = useLocalSearchParams<{ user?: string }>();
  const userName = params.user ? String(params.user) : undefined;

  return (
    <SafeAreaView style={styles.safeArea}>
      <LinearGradient
        colors={['#0048B3', '#0E8CFF']}
        start={{ x: 0, y: 0 }}
        end={{ x: 1, y: 0 }}
        style={styles.header}>
        <Image source={logoSource} style={styles.headerLogo} contentFit="contain" />
      </LinearGradient>

      <View style={styles.titleBar}>
        <Pressable onPress={() => router.back()} hitSlop={12} style={styles.titleLeft}>
          <MaterialCommunityIcons name="arrow-left" size={22} color="#0A2B7E" />
          <Text style={styles.titleText}>Kelola Outlet</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Pengaturan Outlet</Text>
          <View style={styles.card}>
            {SETTINGS.map((item, idx) => (
              <View key={item.title}>
                <Pressable
                  style={styles.row}
                  onPress={() => {
                    if (item.route) {
                      const params = userName ? { user: userName } : undefined;
                      router.push({ pathname: item.route, params });
                    }
                  }}>
                  <MaterialCommunityIcons name={item.icon} size={26} color="#0A4DA8" />
                  <Text style={styles.rowText}>{item.title}</Text>
                </Pressable>
                {idx < SETTINGS.length - 1 ? <View style={styles.divider} /> : null}
              </View>
            ))}
          </View>
        </View>

        <View style={styles.section}>
          <Text style={[styles.sectionTitle, styles.sectionTitleOrange]}>Aktivasi Fitur</Text>
          <View style={styles.card}>
            {FEATURES.map((item, idx) => (
              <View key={item.title}>
                <View style={styles.row}>
                  <MaterialCommunityIcons name={item.icon} size={26} color="#0A4DA8" />
                  <Text style={styles.rowText}>{item.title}</Text>
                </View>
                {idx < FEATURES.length - 1 ? <View style={styles.divider} /> : null}
              </View>
            ))}
          </View>
        </View>
      </ScrollView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#F6F7FB',
  },
  header: {
    paddingHorizontal: 20,
    paddingVertical: 14,
    alignItems: 'center',
    justifyContent: 'center',
  },
  headerLogo: {
    width: 130,
    height: 44,
  },
  titleBar: {
    backgroundColor: '#fff',
    paddingHorizontal: 14,
    paddingVertical: 12,
    flexDirection: 'row',
    alignItems: 'center',
    borderBottomWidth: 1,
    borderBottomColor: '#E5E7EB',
    borderTopLeftRadius: 16,
    borderTopRightRadius: 16,
  },
  titleLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
  },
  titleText: {
    fontSize: 16,
    fontWeight: '700',
    color: '#0B245A',
  },
  scrollContent: {
    padding: 14,
    gap: 18,
    paddingBottom: 40,
  },
  section: {
    gap: 8,
  },
  sectionTitle: {
    color: '#0A4DA8',
    fontWeight: '700',
  },
  sectionTitleOrange: {
    color: '#F28C0F',
  },
  card: {
    backgroundColor: '#fff',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#E5E7EB',
    paddingHorizontal: 12,
    paddingVertical: 8,
  },
  row: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 12,
    paddingVertical: 10,
  },
  rowText: {
    color: '#0B245A',
    fontWeight: '600',
  },
  divider: {
    borderBottomWidth: 1,
    borderBottomColor: '#E9ECF2',
  },
});
