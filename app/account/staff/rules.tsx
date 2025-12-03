import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useRouter } from 'expo-router';
import React, { useState } from 'react';
import { Pressable, ScrollView, StyleSheet, Text, TextInput, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');

export default function AttendanceRulesScreen() {
  const router = useRouter();
  const [radius, setRadius] = useState('50');
  const [withinRadius, setWithinRadius] = useState<'ya' | 'tidak'>('ya');
  const [needSelfie, setNeedSelfie] = useState<'ya' | 'tidak'>('tidak');

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
          <Text style={styles.titleText}>Aturan Presensi</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.mapPlaceholder}>
          <MaterialCommunityIcons name="map-marker-radius" size={38} color="#E53935" />
          <Text style={styles.mapText}>Lokasi presensi terdeteksi dari alamat utama outlet.</Text>
          <Text style={styles.mapLink}>Ubah Disini</Text>
        </View>

        <Text style={styles.label}>Radius (meter)</Text>
        <TextInput
          style={styles.input}
          keyboardType="numeric"
          value={radius}
          onChangeText={setRadius}
        />

        <Text style={styles.label}>Wajib Dalam Radius</Text>
        <View style={styles.radioRow}>
          {(['ya', 'tidak'] as const).map((v) => (
            <Pressable key={v} style={styles.radioItem} onPress={() => setWithinRadius(v)}>
              <View style={[styles.radioOuter, withinRadius === v && styles.radioOuterActive]}>
                {withinRadius === v ? <View style={styles.radioInner} /> : null}
              </View>
              <Text style={styles.radioLabel}>{v === 'ya' ? 'Ya' : 'Tidak'}</Text>
            </Pressable>
          ))}
        </View>

        <Text style={styles.label}>Wajib Selfie</Text>
        <View style={styles.radioRow}>
          {(['ya', 'tidak'] as const).map((v) => (
            <Pressable key={v} style={styles.radioItem} onPress={() => setNeedSelfie(v)}>
              <View style={[styles.radioOuter, needSelfie === v && styles.radioOuterActive]}>
                {needSelfie === v ? <View style={styles.radioInner} /> : null}
              </View>
              <Text style={styles.radioLabel}>{v === 'ya' ? 'Ya' : 'Tidak'}</Text>
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
  mapPlaceholder: {
    backgroundColor: '#fff',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#E5E7EB',
    padding: 16,
    alignItems: 'center',
    gap: 8,
  },
  mapText: { color: '#4B5C8B', textAlign: 'center' },
  mapLink: { color: '#0A6CFF', fontWeight: '700' },
  label: { color: '#0B245A', fontWeight: '700' },
  input: {
    backgroundColor: '#F1F3F8',
    borderRadius: 12,
    paddingHorizontal: 12,
    paddingVertical: 10,
    color: '#0B245A',
  },
  radioRow: { flexDirection: 'row', alignItems: 'center', gap: 12 },
  radioItem: { flexDirection: 'row', alignItems: 'center', gap: 8 },
  radioOuter: {
    width: 20,
    height: 20,
    borderRadius: 10,
    borderWidth: 2,
    borderColor: '#BFC7DA',
    alignItems: 'center',
    justifyContent: 'center',
  },
  radioOuterActive: { borderColor: '#0A4DA8' },
  radioInner: { width: 10, height: 10, borderRadius: 5, backgroundColor: '#0A4DA8' },
  radioLabel: { color: '#0B245A', fontWeight: '600' },
  saveButton: {
    marginTop: 8,
    backgroundColor: '#0A6CFF',
    borderRadius: 10,
    paddingVertical: 14,
    alignItems: 'center',
  },
  saveText: { color: '#fff', fontWeight: '700', letterSpacing: 0.5 },
});
