import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useLocalSearchParams, useRouter } from 'expo-router';
import React, { useMemo } from 'react';
import { Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');
const EMPTY_ILLUSTRATION =
  'https://raw.githubusercontent.com/duyng404/illustrations/main/laundry-empty.png';

const TITLE_MAP: Record<string, string> = {
  'bagian-pegawai': 'Bagian Pegawai',
  'bagian-admin': 'Bagian Admin',
  'bagian-produksi': 'Bagian Produksi',
  'bagian-kurir': 'Bagian Kurir',
  'rekap-absensi': 'Rekap Absensi',
  'rekap-lembur': 'Rekap Lembur',
};

export default function StaffReportDetail() {
  const router = useRouter();
  const params = useLocalSearchParams<{ slug?: string }>();

  const title = useMemo(() => {
    if (params.slug && TITLE_MAP[params.slug]) return TITLE_MAP[params.slug];
    return 'Laporan Pegawai';
  }, [params.slug]);

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
          <Text style={styles.titleText}>{title}</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.filterRow}>
          <View style={styles.filterLeft}>
            <MaterialCommunityIcons name="calendar-month-outline" size={20} color="#0A4DA8" />
            <Text style={styles.filterText}>Filter</Text>
            <MaterialCommunityIcons name="chevron-down" size={18} color="#0A4DA8" />
          </View>
          <Pressable style={styles.iconButton}>
            <MaterialCommunityIcons name="printer" size={20} color="#0A4DA8" />
          </Pressable>
        </View>
        <View style={styles.dateRow}>
          <Text style={styles.dateLabel}>Pilih Tanggal</Text>
        </View>

        <View style={styles.emptyState}>
          <Image
            source={{ uri: EMPTY_ILLUSTRATION }}
            style={styles.illustration}
            contentFit="contain"
          />
          <Text style={styles.emptyText}>Belum ada data</Text>
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
    paddingHorizontal: 14,
    paddingTop: 12,
    paddingBottom: 40,
  },
  filterRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    backgroundColor: '#fff',
    paddingHorizontal: 12,
    paddingVertical: 10,
    borderWidth: 1,
    borderColor: '#E5E7EB',
    borderTopLeftRadius: 12,
    borderTopRightRadius: 12,
  },
  filterLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
  },
  filterText: {
    color: '#0A4DA8',
    fontWeight: '700',
  },
  iconButton: {
    padding: 6,
    borderRadius: 10,
    backgroundColor: '#EEF3FF',
  },
  dateRow: {
    backgroundColor: '#fff',
    borderWidth: 1,
    borderColor: '#E5E7EB',
    borderTopWidth: 0,
    paddingHorizontal: 12,
    paddingVertical: 12,
    marginBottom: 12,
    borderBottomLeftRadius: 12,
    borderBottomRightRadius: 12,
  },
  dateLabel: {
    color: '#4B5C8B',
    fontWeight: '600',
  },
  emptyState: {
    alignItems: 'center',
    gap: 14,
    marginTop: 10,
  },
  illustration: {
    width: 260,
    height: 180,
  },
  emptyText: {
    color: '#7B88B2',
    fontSize: 13,
  },
});
