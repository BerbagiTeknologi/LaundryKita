import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useLocalSearchParams, useRouter } from 'expo-router';
import React, { useEffect, useState } from 'react';
import { Alert, Pressable, ScrollView, StyleSheet, Text, TextInput, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');
import { getSession } from '@/lib/session';
import { updateProfile } from '@/lib/auth';

export default function OutletProfileScreen() {
  const router = useRouter();
  const params = useLocalSearchParams<{ user?: string; company?: string; phone?: string }>();
  const userName = params.user ? String(params.user) : undefined;
  const [timezone, setTimezone] = useState<'WIB' | 'WITA' | 'WIT'>('WIB');
  const [outletName, setOutletName] = useState(params.company ? String(params.company) : '');
  const [address, setAddress] = useState('');
  const [province, setProvince] = useState('');
  const [city, setCity] = useState('');
  const [phone, setPhone] = useState(params.phone ? String(params.phone) : '');
  const [loading, setLoading] = useState(false);
  const [errorMessage, setErrorMessage] = useState<string | null>(null);

  useEffect(() => {
    if (!outletName && userName) {
      setOutletName(userName);
    }
  }, [outletName, userName]);

  const handleSave = async () => {
    if (loading) return;
    if (!outletName || !phone) {
      setErrorMessage('Nama outlet dan telepon wajib diisi.');
      return;
    }
    setErrorMessage(null);
    setLoading(true);
    try {
      const session = await getSession();
      if (!session.token) {
        throw new Error('Token tidak ditemukan, silakan login ulang.');
      }
      await updateProfile(session.token, {
        company_name: outletName,
        phone,
        address,
        province,
        city,
        timezone,
      });
      Alert.alert('Berhasil', 'Profil outlet berhasil diperbarui.');
      router.back();
    } catch (error) {
      if (error instanceof Error) {
        setErrorMessage(error.message);
      } else {
        setErrorMessage('Gagal menyimpan profil.');
      }
    } finally {
      setLoading(false);
    }
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
          <Text style={styles.titleText}>Edit Profil Outlet</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.headerRow}>
          <View style={styles.avatar}>
            <MaterialCommunityIcons name="storefront-outline" size={32} color="#0A4DA8" />
          </View>
          <View style={{ flex: 1 }}>
            <Text style={styles.label}>Nama Outlet</Text>
            <TextInput
              style={styles.input}
              value={outletName}
              onChangeText={setOutletName}
              placeholder="Nama Outlet"
              placeholderTextColor="rgba(11,43,122,0.4)"
              editable={!loading}
            />
          </View>
        </View>

        <Text style={styles.label}>Alamat</Text>
        <TextInput
          style={[styles.input, styles.textArea, styles.inputFocus]}
          multiline
          value={address}
          onChangeText={setAddress}
          editable={!loading}
        />

        <Text style={styles.label}>Provinsi</Text>
        <TextInput
          style={styles.input}
          value={province}
          onChangeText={setProvince}
          editable={!loading}
        />

        <Text style={styles.label}>Kabupaten/Kota</Text>
        <TextInput
          style={styles.input}
          value={city}
          onChangeText={setCity}
          editable={!loading}
        />

        <Text style={styles.label}>Telepon</Text>
        <TextInput
          style={styles.input}
          keyboardType="phone-pad"
          value={phone}
          onChangeText={setPhone}
          editable={!loading}
        />

        <Text style={styles.label}>Zona Waktu</Text>
        <View style={styles.radioRow}>
          {(['WIB', 'WITA', 'WIT'] as const).map((tz) => (
            <Pressable
              key={tz}
              style={styles.radioItem}
              onPress={() => setTimezone(tz)}
              hitSlop={8}>
              <View style={[styles.radioOuter, timezone === tz && styles.radioOuterActive]}>
                {timezone === tz ? <View style={styles.radioInner} /> : null}
              </View>
              <Text style={styles.radioLabel}>{tz}</Text>
            </Pressable>
          ))}
          <Pressable style={styles.bannerButton}>
            <Text style={styles.bannerText}>Ganti Banner</Text>
          </Pressable>
        </View>

        {errorMessage ? <Text style={styles.errorText}>{errorMessage}</Text> : null}

        <Pressable style={[styles.saveButton, loading && styles.saveButtonDisabled]} onPress={handleSave} disabled={loading}>
          <Text style={styles.saveText}>{loading ? 'Menyimpan...' : 'SIMPAN'}</Text>
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
  scrollContent: { padding: 16, paddingBottom: 40, gap: 12 },
  headerRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 12,
  },
  avatar: {
    width: 64,
    height: 64,
    borderRadius: 18,
    backgroundColor: '#E7F0FF',
    alignItems: 'center',
    justifyContent: 'center',
    borderWidth: 1,
    borderColor: '#D6E6FF',
  },
  label: {
    color: '#0B245A',
    fontWeight: '700',
  },
  input: {
    backgroundColor: '#F1F3F8',
    borderRadius: 16,
    paddingHorizontal: 14,
    paddingVertical: 12,
    color: '#0B245A',
  },
  inputFocus: {
    borderWidth: 1.5,
    borderColor: '#2F80ED',
    backgroundColor: '#F8FBFF',
  },
  textArea: {
    minHeight: 90,
    textAlignVertical: 'top',
  },
  radioRow: {
    flexDirection: 'row',
    alignItems: 'center',
    flexWrap: 'wrap',
    gap: 12,
  },
  radioItem: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
  },
  radioOuter: {
    width: 20,
    height: 20,
    borderRadius: 10,
    borderWidth: 2,
    borderColor: '#BFC7DA',
    alignItems: 'center',
    justifyContent: 'center',
  },
  radioOuterActive: {
    borderColor: '#FF8A00',
  },
  radioInner: {
    width: 10,
    height: 10,
    borderRadius: 5,
    backgroundColor: '#FF8A00',
  },
  radioLabel: {
    color: '#0B245A',
    fontWeight: '600',
  },
  bannerButton: {
    marginLeft: 'auto',
    backgroundColor: '#F1F3F8',
    borderRadius: 12,
    paddingHorizontal: 12,
    paddingVertical: 8,
  },
  bannerText: {
    color: '#0B245A',
    fontWeight: '700',
  },
  saveButton: {
    marginTop: 8,
    backgroundColor: '#0A6CFF',
    borderRadius: 10,
    paddingVertical: 14,
    alignItems: 'center',
  },
  saveButtonDisabled: {
    opacity: 0.6,
  },
  saveText: {
    color: '#fff',
    fontWeight: '700',
    letterSpacing: 0.5,
  },
  errorText: {
    color: '#FF5A5F',
    fontWeight: '700',
    textAlign: 'center',
  },
});
