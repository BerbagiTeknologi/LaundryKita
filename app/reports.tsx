import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useLocalSearchParams, usePathname, useRouter } from 'expo-router';
import React, { useEffect, useState } from 'react';
import { LayoutAnimation, Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';
import { SafeAreaView, useSafeAreaInsets } from 'react-native-safe-area-context';

import { Fonts } from '@/constants/theme';
import { getSession } from '@/lib/session';

const logoSource = require('@/assets/images/logo.png');

type ReportCategory =
  | 'keuangan'
  | 'transaksi'
  | 'persediaan'
  | 'pegawai'
  | 'pelanggan'
  | 'export';

type ReportItem = {
  title: string;
  icon: keyof typeof MaterialCommunityIcons.glyphMap;
  slug?: string;
};

const REPORT_SECTIONS: { key: ReportCategory; title: string; items: ReportItem[] }[] = [
  {
    key: 'keuangan',
    title: 'Laporan Keuangan',
    items: [
      { title: 'Analisa Omzet', icon: 'chart-line', slug: 'analisa-omzet' },
      { title: 'Arus Keuangan', icon: 'swap-horizontal', slug: 'arus-keuangan' },
      { title: 'Pendapatan Transaksi', icon: 'credit-card-multiple-outline', slug: 'pendapatan-transaksi' },
      { title: 'Pendapatan Jual Produk', icon: 'cart-check', slug: 'pendapatan-jual-produk' },
      { title: 'Pendapatan Lain', icon: 'wallet-plus', slug: 'pendapatan-lain' },
      { title: 'Pengeluaran', icon: 'cash-minus', slug: 'pengeluaran' },
      { title: 'Chart of Account', icon: 'chart-bubble', slug: 'chart-of-account' },
    ],
  },
  {
    key: 'transaksi',
    title: 'Laporan Transaksi',
    items: [
      { title: 'Semua Data Transaksi', icon: 'file-document-outline', slug: 'semua-data' },
      { title: 'Transaksi Jual Produk', icon: 'tshirt-crew-outline', slug: 'jual-produk' },
      { title: 'Transaksi Ditolak/Dibatalkan', icon: 'close-octagon-outline', slug: 'ditolak' },
      { title: 'Faktur Yang Ditagihkan', icon: 'note-text-outline', slug: 'faktur-ditagihkan' },
      { title: 'Top Layanan', icon: 'star-circle-outline', slug: 'top-layanan' },
    ],
  },
  {
    key: 'persediaan',
    title: 'Laporan Persediaan',
    items: [
      { title: 'Pembelian Produk', icon: 'cart-outline', slug: 'pembelian-produk' },
      { title: 'Persediaan Produk', icon: 'tray-full', slug: 'persediaan-produk' },
      { title: 'Nilai Persediaan Produk', icon: 'scale-balance', slug: 'nilai-persediaan' },
      { title: 'Stok Opname', icon: 'inbox-arrow-up-outline', slug: 'stok-opname' },
    ],
  },
  {
    key: 'pegawai',
    title: 'Laporan Pegawai',
    items: [
      { title: 'Bagian Pegawai', icon: 'account-group', slug: 'bagian-pegawai' },
      { title: 'Bagian Admin', icon: 'account-tie', slug: 'bagian-admin' },
      { title: 'Bagian Produksi', icon: 'factory', slug: 'bagian-produksi' },
      { title: 'Bagian Kurir', icon: 'motorbike', slug: 'bagian-kurir' },
      { title: 'Rekap Absensi', icon: 'calendar-check-outline', slug: 'rekap-absensi' },
      { title: 'Rekap Lembur', icon: 'clock-plus-outline', slug: 'rekap-lembur' },
    ],
  },
  {
    key: 'pelanggan',
    title: 'Laporan Pelanggan',
    items: [
      { title: 'Pertumbuhan Pelanggan', icon: 'account-multiple-plus-outline', slug: 'pertumbuhan' },
      { title: 'Top Pelanggan', icon: 'trophy', slug: 'top-pelanggan' },
      { title: 'Riwayat Faktur Pelanggan', icon: 'file-clock-outline', slug: 'riwayat-faktur' },
    ],
  },
  {
    key: 'export',
    title: 'Export Data',
    items: [
      { title: 'Pelanggan', icon: 'account-arrow-down', slug: 'export-pelanggan' },
      { title: 'Keuangan', icon: 'file-export-outline', slug: 'export-keuangan' },
      { title: 'Laporan Transaksi', icon: 'file-export', slug: 'export-transaksi' },
      { title: 'Laporan Persediaan', icon: 'cube-send', slug: 'export-persediaan' },
      { title: 'Laporan Pegawai', icon: 'account-tie', slug: 'export-pegawai' },
      { title: 'Laporan Pelanggan', icon: 'text-account', slug: 'export-pelanggan-data' },
    ],
  },
];

export default function ReportsScreen() {
  const insets = useSafeAreaInsets();
  const params = useLocalSearchParams<{ user?: string }>();
  const router = useRouter();
  const pathname = usePathname();
  const [expanded, setExpanded] = useState<ReportCategory | null>(null);
  const [userName, setUserName] = useState<string>(
    params.user ? String(params.user) : 'Ahmad Laundry',
  );

  useEffect(() => {
    if (params.user) return;
    getSession().then((session) => {
      if (session.user) {
        setUserName(session.user);
      }
    });
  }, [params.user]);

  const toggle = (key: ReportCategory) => {
    LayoutAnimation.configureNext(LayoutAnimation.Presets.easeInEaseOut);
    setExpanded((prev) => (prev === key ? null : key));
  };

  return (
    <SafeAreaView style={[styles.safeArea, { paddingTop: 0 }]}>
      <LinearGradient
        colors={['#0048B3', '#0E8CFF']}
        start={{ x: 0, y: 0 }}
        end={{ x: 1, y: 0 }}
        style={styles.header}>
        <Image source={logoSource} style={styles.headerLogo} contentFit="contain" />
        <Pressable style={styles.bellButton}>
          <MaterialCommunityIcons name="bell-outline" size={24} color="#fff" />
        </Pressable>
      </LinearGradient>
      <ScrollView
        contentContainerStyle={[
          styles.scrollContent,
          { paddingBottom: 140 + insets.bottom, paddingTop: 12 },
        ]}
        showsVerticalScrollIndicator={false}>
        <View style={styles.greetingCard}>
          <Text style={styles.greetingTitle}>Hai, {userName}</Text>
          <Text style={styles.greetingSubtitle}>Ini adalah laporan usaha laundry kamu</Text>
        </View>

        <View style={styles.listCard}>
          {REPORT_SECTIONS.map((section, idx) => {
            const isExpanded = expanded === section.key;
            return (
              <View key={section.key}>
                <Pressable style={styles.listHeader} onPress={() => toggle(section.key)}>
                  <View style={styles.headerLeft}>
                    <MaterialCommunityIcons
                      name={getSectionIcon(section.key)}
                      size={22}
                      color="#0A4DA8"
                    />
                    <Text style={styles.listHeaderText}>{section.title}</Text>
                  </View>
                  <MaterialCommunityIcons
                    name={isExpanded ? 'chevron-up' : 'chevron-down'}
                    size={22}
                    color="#0A4DA8"
                  />
                </Pressable>
                {isExpanded ? (
                  <View style={styles.itemsContainer}>
                    {section.items.map((item) => {
                      const isFinance = section.key === 'keuangan' && item.slug;
                      const isChart = item.slug === 'chart-of-account';
                      const isTransaction = section.key === 'transaksi' && item.slug;
                      const isInventory = section.key === 'persediaan' && item.slug;
                      const isStaff = section.key === 'pegawai' && item.slug;
                      const isCustomer = section.key === 'pelanggan' && item.slug;
                      const isExport = section.key === 'export' && item.slug;
                      const isLink =
                        (isFinance || isTransaction || isInventory || isStaff || isCustomer || isExport) &&
                        item.slug;
                      return (
                        <Pressable
                          key={item.title}
                          style={({ pressed }) => [
                            styles.itemRow,
                            pressed && isLink && styles.itemRowPressed,
                          ]}
                          disabled={!isLink}
                          onPress={() => {
                            if (!isLink) return;
                            const params = { ...(userName ? { user: userName } : {}), slug: item.slug! };
                            if (isChart) {
                              router.push({ pathname: '/reports/chart-of-account', params });
                            } else if (isFinance) {
                              router.push({ pathname: '/reports/finance/[slug]', params });
                            } else if (isTransaction) {
                              router.push({ pathname: '/reports/transactions/[slug]', params });
                            } else if (isInventory) {
                              router.push({ pathname: '/reports/inventory/[slug]', params });
                            } else if (isStaff) {
                              router.push({ pathname: '/reports/staff/[slug]', params });
                            } else if (isCustomer) {
                              router.push({ pathname: '/reports/customers/[slug]', params });
                            } else if (isExport) {
                              router.push({ pathname: '/reports/export/[slug]', params });
                            }
                          }}>
                          <View style={styles.itemLeft}>
                            <MaterialCommunityIcons name={item.icon} size={20} color="#4B5C8B" />
                            <Text style={styles.itemText}>{item.title}</Text>
                          </View>
                        </Pressable>
                      );
                    })}
                  </View>
                ) : null}
                {idx < REPORT_SECTIONS.length - 1 ? <View style={styles.divider} /> : null}
              </View>
            );
          })}
        </View>
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

function getSectionIcon(key: ReportCategory): keyof typeof MaterialCommunityIcons.glyphMap {
  switch (key) {
    case 'keuangan':
      return 'cash-multiple';
    case 'transaksi':
      return 'file-document-outline';
    case 'persediaan':
      return 'cube-outline';
    case 'pegawai':
      return 'account-group-outline';
    case 'pelanggan':
      return 'account-multiple';
    case 'export':
      return 'file-export-outline';
    default:
      return 'chart-arc';
  }
}

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#F6F7FB',
  },
  scrollContent: {
    paddingBottom: 120,
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
  bellButton: {
    padding: 8,
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
  outletCard: {
    marginHorizontal: 14,
    marginTop: 8,
    backgroundColor: '#F8FBFF',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#E4EBF7',
    padding: 12,
    gap: 4,
  },
  outletTitle: {
    fontSize: 14,
    fontWeight: '700',
    color: '#0A4DA8',
  },
  outletSubtitle: {
    fontSize: 12,
    color: '#7A879B',
  },
  listCard: {
    marginTop: 12,
    marginHorizontal: 14,
    backgroundColor: '#fff',
    borderRadius: 16,
    borderWidth: 1,
    borderColor: '#E5E7EB',
    paddingHorizontal: 10,
    paddingVertical: 6,
  },
  listHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 12,
  },
  headerLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
  },
  listHeaderText: {
    fontSize: 14,
    fontWeight: '700',
    color: '#0B245A',
  },
  itemsContainer: {
    paddingBottom: 8,
    gap: 14,
    paddingHorizontal: 10,
  },
  itemRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 10,
    paddingHorizontal: 6,
    borderRadius: 10,
  },
  itemRowPressed: {
    backgroundColor: '#EEF3FF',
  },
  itemLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 12,
  },
  itemText: {
    fontSize: 13,
    color: '#4B5C8B',
    fontWeight: '600',
  },
  divider: {
    borderBottomWidth: 1,
    borderBottomColor: '#EDF0F5',
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
