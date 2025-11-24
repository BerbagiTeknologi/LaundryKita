import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import React, { useEffect, useMemo, useState } from 'react';
import { Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';
import { SafeAreaView, useSafeAreaInsets } from 'react-native-safe-area-context';

import { Fonts } from '@/constants/theme';
import { useLocalSearchParams, usePathname, useRouter } from 'expo-router';
import { getSession } from '@/lib/session';

const logoSource = require('@/assets/images/logo.png');

const EMPTY_ILLUSTRATION =
  'https://raw.githubusercontent.com/duyng404/illustrations/main/laundry-empty.png';

type TabKey =
  | 'konfirmasi'
  | 'penjemputan'
  | 'validasi'
  | 'antrian'
  | 'proses'
  | 'siap-ambil'
  | 'siap-antar';

const TAB_LABELS: { key: TabKey; label: string }[] = [
  { key: 'konfirmasi', label: 'Konfirmasi' },
  { key: 'penjemputan', label: 'Penjemputan' },
  { key: 'validasi', label: 'Validasi' },
  { key: 'antrian', label: 'Antrian' },
  { key: 'proses', label: 'Proses' },
  { key: 'siap-ambil', label: 'Siap Ambil' },
  { key: 'siap-antar', label: 'Siap Antar' },
];

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#F6F7FB',
  },
  scrollContent: {
    paddingBottom: 140,
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: 20,
    paddingVertical: 14,
  },
  headerLogo: {
    width: 120,
    height: 42,
  },
  headerActions: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 12,
  },
  greetingCard: {
    paddingHorizontal: 18,
    paddingVertical: 12,
    gap: 4,
  },
  greetingTitle: {
    fontSize: 20,
    fontFamily: Fonts.rounded,
    fontWeight: '700',
    color: '#0B245A',
  },
  greetingSubtitle: {
    fontSize: 13,
    color: '#4B5C8B',
  },
  tabsRow: {
    marginTop: 4,
    paddingHorizontal: 14,
  },
  tabStrip: {
    flexDirection: 'row',
    backgroundColor: '#E8F1FF',
    borderRadius: 14,
    padding: 4,
    gap: 6,
  },
  tabButton: {
    alignItems: 'center',
    paddingVertical: 8,
    paddingHorizontal: 10,
    borderRadius: 10,
  },
  tabButtonActive: {
    backgroundColor: '#0A6CFF',
  },
  tabText: {
    fontSize: 13,
    fontWeight: '700',
    color: '#43629D',
  },
  tabTextActive: {
    color: '#fff',
  },
  emptyState: {
    marginTop: 36,
    alignItems: 'center',
    gap: 16,
  },
  illustration: {
    width: 260,
    height: 180,
  },
  emptyText: {
    color: '#7B88B2',
    fontSize: 13,
  },
  bottomNav: {
    position: 'absolute',
    bottom: 0,
    left: 0,
    right: 0,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: 18,
    paddingVertical: 12,
    backgroundColor: '#fff',
    borderTopWidth: 1,
    borderTopColor: '#E5E7EB',
  },
  navItem: {
    alignItems: 'center',
    gap: 4,
  },
  navItemProminent: {
    backgroundColor: '#2F78D3',
    width: 68,
    height: 68,
    borderRadius: 34,
    alignItems: 'center',
    justifyContent: 'center',
    marginTop: -24,
    shadowColor: '#000',
    shadowOpacity: 0.2,
    shadowRadius: 10,
    shadowOffset: { width: 0, height: 4 },
    elevation: 8,
  },
  navLabel: {
    color: '#0A4DA8',
    fontSize: 11,
    fontWeight: '700',
  },
  navItemDisabled: {
    opacity: 0.55,
  },
});

export default function OrdersScreen() {
  const params = useLocalSearchParams<{ user?: string; tab?: string }>();
  const insets = useSafeAreaInsets();
  const router = useRouter();
  const pathname = usePathname();
  const [userName, setUserName] = useState<string>(
    params.user ? String(params.user) : 'Ahmad Laundry',
  );
  const [activeTab, setActiveTab] = useState<TabKey>('konfirmasi');

  useEffect(() => {
    if (params.user) return;
    getSession().then((session) => {
      if (session.user) setUserName(session.user);
    });
  }, [params.user]);

  useEffect(() => {
    if (params.tab && (TAB_LABELS as { key: string }[]).some((t) => t.key === params.tab)) {
      setActiveTab(params.tab as TabKey);
    }
  }, [params.tab]);

  const tabContent = useMemo(() => {
    return (
      <View style={styles.emptyState}>
        <Image
          source={{ uri: EMPTY_ILLUSTRATION }}
          style={styles.illustration}
          contentFit="contain"
        />
        <Text style={styles.emptyText}>Belum ada data</Text>
      </View>
    );
  }, []);

  return (
    <SafeAreaView style={[styles.safeArea, { paddingTop: 0 }]}>
      <LinearGradient
        colors={['#0048B3', '#0E8CFF']}
        start={{ x: 0, y: 0 }}
        end={{ x: 1, y: 0 }}
        style={styles.header}>
        <Image source={logoSource} style={styles.headerLogo} contentFit="contain" />
        <View style={styles.headerActions}>
          <MaterialCommunityIcons name="magnify" size={22} color="#fff" />
          <MaterialCommunityIcons name="qrcode-scan" size={22} color="#fff" />
        </View>
      </LinearGradient>

      <ScrollView
        contentContainerStyle={[
          styles.scrollContent,
          { paddingBottom: 160 + insets.bottom, paddingTop: 12 },
        ]}
        showsVerticalScrollIndicator={false}>
        <View style={styles.greetingCard}>
          <Text style={styles.greetingTitle}>Hai, {userName}</Text>
          <Text style={styles.greetingSubtitle}>Ini status orderan kamu</Text>
        </View>

        <View style={styles.tabsRow}>
          <ScrollView
            horizontal
            showsHorizontalScrollIndicator={false}
            contentContainerStyle={styles.tabStrip}>
            {TAB_LABELS.map((tab) => {
              const active = activeTab === tab.key;
              return (
                <Pressable
                  key={tab.key}
                  style={[styles.tabButton, active && styles.tabButtonActive]}
                  onPress={() => setActiveTab(tab.key)}>
                  <Text style={[styles.tabText, active && styles.tabTextActive]}>{tab.label}</Text>
                </Pressable>
              );
            })}
          </ScrollView>
        </View>

        {tabContent}
      </ScrollView>

      <View style={[styles.bottomNav, { paddingBottom: 16 + insets.bottom }]}>
        {navItems.map((item) => (
          <Pressable
            key={item.label}
            style={[
              styles.navItem,
              item.prominent && styles.navItemProminent,
              item.route === pathname && styles.navItemDisabled,
            ]}
            onPress={() => {
              if (item.route && item.route !== pathname) {
                const params = userName ? { user: userName } : undefined;
                router.push({ pathname: item.route, params });
              }
            }}>
            <MaterialCommunityIcons
              name={item.icon as any}
              size={item.prominent ? 36 : 22}
              color={item.prominent ? '#fff' : '#0A4DA8'}
            />
            {!item.prominent ? <Text style={styles.navLabel}>{item.label}</Text> : null}
          </Pressable>
        ))}
      </View>
    </SafeAreaView>
  );
}

const navItems: {
  label: string;
  icon: keyof typeof MaterialCommunityIcons.glyphMap;
  prominent?: boolean;
  route?: '/home' | '/orders' | '/reports' | '/account';
}[] = [
  { label: 'Beranda', icon: 'home-variant', route: '/home' },
  { label: 'Pesanan', icon: 'clipboard-list-outline', route: '/orders' },
  { label: 'Tambah', icon: 'plus-circle', prominent: true },
  { label: 'Laporan', icon: 'chart-line', route: '/reports' },
  { label: 'Akun', icon: 'account-outline', route: '/account' },
];
