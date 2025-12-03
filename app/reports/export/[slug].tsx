import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useLocalSearchParams, useRouter } from 'expo-router';
import React, { useMemo } from 'react';
import { Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');

const TITLE_MAP: Record<string, string> = {
  'export-pelanggan': 'Export Pelanggan',
  'export-keuangan': 'Export Keuangan',
  'export-transaksi': 'Export Transaksi',
  'export-persediaan': 'Export Persediaan',
  'export-pegawai': 'Export Pegawai',
  'export-pelanggan-data': 'Export Pelanggan',
};

export default function ExportReportDetail() {
  const router = useRouter();
  const params = useLocalSearchParams<{ slug?: string }>();

  const title = useMemo(() => {
    if (params.slug && TITLE_MAP[params.slug]) return TITLE_MAP[params.slug];
    return 'Export Data';
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
        <Text style={styles.label}>Pilih Tanggal</Text>
        <View style={styles.yearRow}>
          <View style={styles.yearLeft}>
            <MaterialCommunityIcons name="calendar-blank-outline" size={20} color="#0A4DA8" />
            <Text style={styles.yearText}>2025</Text>
            <MaterialCommunityIcons name="chevron-down" size={18} color="#0A4DA8" />
          </View>
        </View>

        <Text style={styles.sectionTitle}>Data Laporan</Text>
        <Pressable style={styles.reportCard}>
          <View style={styles.reportLeft}>
            <View style={styles.xlsBadge}>
              <Text style={styles.xlsText}>XLS</Text>
            </View>
            <View>
              <Text style={styles.reportTitle}>Juni 2025</Text>
              <Text style={styles.reportSubtitle}>Dari 01/06/2025 sampai 30/06/2025</Text>
            </View>
          </View>
          <MaterialCommunityIcons name="download" size={22} color="#0A2B7E" />
        </Pressable>
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
    gap: 14,
  },
  label: {
    color: '#0B245A',
    fontWeight: '600',
  },
  yearRow: {
    backgroundColor: '#fff',
    paddingHorizontal: 12,
    paddingVertical: 12,
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#E5E7EB',
  },
  yearLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
  },
  yearText: {
    color: '#0B245A',
    fontWeight: '700',
  },
  sectionTitle: {
    marginTop: 6,
    color: '#0A45C0',
    fontWeight: '700',
  },
  reportCard: {
    backgroundColor: '#fff',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#DCE4F2',
    padding: 12,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    shadowColor: '#000',
    shadowOpacity: 0.08,
    shadowRadius: 8,
    shadowOffset: { width: 0, height: 3 },
    elevation: 3,
  },
  reportLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
  },
  xlsBadge: {
    width: 42,
    height: 42,
    borderRadius: 10,
    backgroundColor: '#E2F2D4',
    alignItems: 'center',
    justifyContent: 'center',
    borderWidth: 1,
    borderColor: '#C8E2B1',
  },
  xlsText: {
    color: '#3D7C20',
    fontWeight: '800',
  },
  reportTitle: {
    color: '#0B245A',
    fontWeight: '700',
  },
  reportSubtitle: {
    color: '#6B7A95',
    fontSize: 12,
  },
});
