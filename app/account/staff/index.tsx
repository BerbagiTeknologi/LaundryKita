import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useLocalSearchParams, useRouter } from 'expo-router';
import React from 'react';
import { Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');

type StaffRoute =
  | '/account/staff/shift'
  | '/account/staff/rules'
  | '/account/staff/groups'
  | '/account/staff/employees';

type Item = { title: string; icon: keyof typeof MaterialCommunityIcons.glyphMap; route?: StaffRoute };

const SETTINGS: Item[] = [
  { title: 'Jam Kerja/Shift', icon: 'calendar-clock', route: '/account/staff/shift' },
  { title: 'Aturan Presensi', icon: 'fingerprint', route: '/account/staff/rules' },
  { title: 'Golongan Pegawai', icon: 'account-multiple', route: '/account/staff/groups' },
];

const STAFF: Item[] = [
  { title: 'Daftar Pegawai', icon: 'account-group-outline', route: '/account/staff/employees' },
  { title: 'Jadwal Pegawai', icon: 'calendar-month' },
  { title: 'Komponen Gaji Pegawai', icon: 'cash-multiple' },
  { title: 'Slip Gaji Pegawai', icon: 'file-document-outline' },
  { title: 'Instruksi ke Pegawai', icon: 'message-arrow-left' },
];

export default function StaffManageScreen() {
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
          <Text style={styles.titleText}>Kelola Pegawai</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.card}>
          <Text style={styles.sectionHeader}>Pengaturan</Text>
          {SETTINGS.map((item, idx) => (
            <View key={item.title}>
              <Pressable
                style={styles.row}
                onPress={() => item.route && router.push({ pathname: item.route, params })}>
                <MaterialCommunityIcons name={item.icon} size={26} color="#0A4DA8" />
                <Text style={styles.rowText}>{item.title}</Text>
              </Pressable>
              {idx < SETTINGS.length - 1 ? <View style={styles.divider} /> : null}
            </View>
          ))}
        </View>

        <View style={styles.card}>
          <Text style={[styles.sectionHeader, styles.sectionHeaderAlt]}>Kepegawaian</Text>
          {STAFF.map((item, idx) => (
            <View key={item.title}>
              <Pressable
                style={styles.row}
                onPress={() => item.route && router.push({ pathname: item.route, params })}>
                <MaterialCommunityIcons name={item.icon} size={26} color="#0A4DA8" />
                <Text style={styles.rowText}>{item.title}</Text>
              </Pressable>
              {idx < STAFF.length - 1 ? <View style={styles.divider} /> : null}
            </View>
          ))}
        </View>
      </ScrollView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safeArea: { flex: 1, backgroundColor: '#F6F7FB' },
  header: {
    paddingHorizontal: 20,
    paddingVertical: 14,
    alignItems: 'center',
    justifyContent: 'center',
  },
  headerLogo: { width: 120, height: 42 },
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
  titleLeft: { flexDirection: 'row', alignItems: 'center', gap: 10 },
  titleText: { fontSize: 16, fontWeight: '700', color: '#0B245A' },
  scrollContent: { padding: 14, paddingBottom: 40, gap: 16 },
  card: {
    backgroundColor: '#fff',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#E5E7EB',
    paddingHorizontal: 12,
    paddingVertical: 8,
  },
  sectionHeader: {
    color: '#0A4DA8',
    fontWeight: '700',
    marginBottom: 8,
  },
  sectionHeaderAlt: {
    color: '#0A4DA8',
  },
  row: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 12,
    paddingVertical: 10,
  },
  rowText: { color: '#0B245A', fontWeight: '600' },
  divider: { borderBottomWidth: 1, borderBottomColor: '#E9ECF2' },
});
