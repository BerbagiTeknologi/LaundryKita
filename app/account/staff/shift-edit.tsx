import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useRouter } from 'expo-router';
import React, { useState } from 'react';
import { Pressable, ScrollView, StyleSheet, Text, TextInput, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');

type DayKey = 'senin' | 'selasa' | 'rabu' | 'kamis' | 'jumat' | 'sabtu' | 'minggu';
const DAYS: { key: DayKey; label: string }[] = [
  { key: 'senin', label: 'Senin' },
  { key: 'selasa', label: 'Selasa' },
  { key: 'rabu', label: 'Rabu' },
  { key: 'kamis', label: 'Kamis' },
  { key: 'jumat', label: 'Jumat' },
  { key: 'sabtu', label: 'Sabtu' },
  { key: 'minggu', label: 'Minggu' },
];

export default function ShiftEditScreen() {
  const router = useRouter();
  const [dispensasi, setDispensasi] = useState('10');
  const [isTomorrow, setIsTomorrow] = useState(false);
  const [activeDays, setActiveDays] = useState<Record<DayKey, boolean>>({
    senin: false,
    selasa: false,
    rabu: false,
    kamis: false,
    jumat: true,
    sabtu: true,
    minggu: true,
  });

  const toggleDay = (key: DayKey) =>
    setActiveDays((prev) => ({
      ...prev,
      [key]: !prev[key],
    }));

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
          <Text style={styles.titleText}>Edit Shift</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.field}>
          <Text style={styles.label}>Nama Waktu</Text>
          <TextInput style={styles.input} defaultValue="Malam" />
        </View>

        <View style={styles.fieldRow}>
          <View style={{ flex: 1 }}>
            <Text style={styles.label}>Jam Masuk</Text>
            <TextInput style={styles.input} defaultValue="16:00" />
          </View>
          <View style={{ flex: 1 }}>
            <Text style={styles.label}>Jam Pulang</Text>
            <TextInput style={styles.input} defaultValue="23:00" />
          </View>
        </View>

        <View style={styles.fieldRow}>
          <View style={{ flex: 1 }}>
            <Text style={styles.label}>Dispensasi Waktu (menit)</Text>
            <TextInput
              style={styles.input}
              keyboardType="numeric"
              value={dispensasi}
              onChangeText={setDispensasi}
            />
            <Text style={styles.helpText}>Isi angka 0 jika tidak menggunakan dispensasi waktu</Text>
          </View>
          <View style={styles.checkboxRow}>
            <Pressable
              style={styles.checkbox}
              onPress={() => setIsTomorrow((prev) => !prev)}
              hitSlop={8}>
              <MaterialCommunityIcons
                name={isTomorrow ? 'checkbox-marked' : 'checkbox-blank-outline'}
                size={22}
                color={isTomorrow ? '#0A4DA8' : '#7B88B2'}
              />
            </Pressable>
            <Text style={styles.label}>Besok</Text>
          </View>
        </View>

        <Text style={styles.label}>Berlaku Untuk Hari</Text>
        <View style={styles.daysGrid}>
          {DAYS.map((day) => (
            <Pressable
              key={day.key}
              style={styles.dayRow}
              onPress={() => toggleDay(day.key)}
              hitSlop={8}>
              <View style={styles.radioOuter}>
                {activeDays[day.key] ? <View style={styles.radioInner} /> : null}
              </View>
              <Text style={styles.dayLabel}>{day.label}</Text>
            </Pressable>
          ))}
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
  scrollContent: { padding: 16, paddingBottom: 40, gap: 14 },
  field: { gap: 8 },
  label: { color: '#0B245A', fontWeight: '700' },
  input: {
    backgroundColor: '#F1F3F8',
    borderRadius: 12,
    paddingHorizontal: 12,
    paddingVertical: 10,
    color: '#0B245A',
  },
  helpText: { color: '#D9534F', fontSize: 12, marginTop: 6 },
  fieldRow: { flexDirection: 'row', gap: 12, alignItems: 'center' },
  checkboxRow: { flexDirection: 'row', alignItems: 'center', gap: 8 },
  checkbox: { padding: 4 },
  daysGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 12,
  },
  dayRow: { flexDirection: 'row', alignItems: 'center', gap: 8, width: '45%' },
  radioOuter: {
    width: 18,
    height: 18,
    borderRadius: 9,
    borderWidth: 2,
    borderColor: '#BFC7DA',
    alignItems: 'center',
    justifyContent: 'center',
  },
  radioInner: {
    width: 9,
    height: 9,
    borderRadius: 5,
    backgroundColor: '#FF8A00',
  },
  dayLabel: { color: '#0B245A', fontWeight: '600' },
  saveButton: {
    marginTop: 8,
    backgroundColor: '#0A6CFF',
    borderRadius: 10,
    paddingVertical: 14,
    alignItems: 'center',
  },
  saveText: { color: '#fff', fontWeight: '700', letterSpacing: 0.5 },
});
