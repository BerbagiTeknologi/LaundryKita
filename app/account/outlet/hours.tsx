import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useLocalSearchParams, useRouter } from 'expo-router';
import React, { useState } from 'react';
import { Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');

type DayKey = 'senin' | 'selasa' | 'rabu' | 'kamis' | 'jumat' | 'sabtu' | 'minggu';
const DAYS: { key: DayKey; label: string; defaultOn?: boolean }[] = [
  { key: 'senin', label: 'Senin', defaultOn: true },
  { key: 'selasa', label: 'Selasa', defaultOn: true },
  { key: 'rabu', label: 'Rabu', defaultOn: true },
  { key: 'kamis', label: 'Kamis', defaultOn: true },
  { key: 'jumat', label: 'Jumat', defaultOn: true },
  { key: 'sabtu', label: 'Sabtu', defaultOn: true },
  { key: 'minggu', label: 'Minggu', defaultOn: false },
];

export default function OutletHoursScreen() {
  const router = useRouter();
  const params = useLocalSearchParams<{ user?: string }>();
  const userName = params.user ? String(params.user) : undefined;
  const [activeDays, setActiveDays] = useState<Record<DayKey, boolean>>(() =>
    DAYS.reduce(
      (acc, cur) => ({ ...acc, [cur.key]: Boolean(cur.defaultOn) }),
      {} as Record<DayKey, boolean>,
    ),
  );

  const toggleDay = (key: DayKey) => {
    setActiveDays((prev) => ({ ...prev, [key]: !prev[key] }));
  };

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
          <Text style={styles.titleText}>Jam Operasional</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.scheduleCard}>
          {DAYS.map((day, idx) => {
            const checked = activeDays[day.key];
            return (
              <View key={day.key}>
                <View style={styles.dayRow}>
                  <Pressable style={styles.checkbox} onPress={() => toggleDay(day.key)}>
                    <MaterialCommunityIcons
                      name={checked ? 'checkbox-marked' : 'checkbox-blank-outline'}
                      size={22}
                      color={checked ? '#F28C0F' : '#7B88B2'}
                    />
                  </Pressable>
                  <Text style={styles.dayLabel}>{day.label}</Text>
                  <View style={styles.timePill}>
                    <Text style={styles.timeText}>Jam Buka</Text>
                  </View>
                  <View style={styles.timePill}>
                    <Text style={styles.timeText}>Jam Tutup</Text>
                  </View>
                </View>
                {idx < DAYS.length - 1 ? <View style={styles.divider} /> : null}
              </View>
            );
          })}
        </View>

        <Pressable style={styles.saveButton}>
          <Text style={styles.saveText}>SIMPAN</Text>
        </Pressable>
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
  headerLogo: { width: 130, height: 44 },
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
  scrollContent: { padding: 16, paddingBottom: 40, gap: 16 },
  scheduleCard: {
    backgroundColor: '#fff',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#E5E7EB',
    paddingHorizontal: 12,
    paddingVertical: 8,
  },
  dayRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
    paddingVertical: 10,
  },
  checkbox: {
    padding: 2,
  },
  dayLabel: {
    width: 70,
    color: '#0B245A',
    fontWeight: '700',
  },
  timePill: {
    flex: 1,
    backgroundColor: '#EFF1F5',
    borderRadius: 16,
    paddingVertical: 8,
    paddingHorizontal: 10,
    alignItems: 'center',
  },
  timeText: {
    color: '#6B7A95',
    fontWeight: '700',
    fontSize: 12,
  },
  divider: {
    borderBottomWidth: 1,
    borderBottomColor: '#E9ECF2',
  },
  saveButton: {
    marginTop: 8,
    backgroundColor: '#0A6CFF',
    borderRadius: 10,
    paddingVertical: 14,
    alignItems: 'center',
  },
  saveText: {
    color: '#fff',
    fontWeight: '700',
    letterSpacing: 0.5,
  },
});
