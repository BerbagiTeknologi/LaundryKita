import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useRouter } from 'expo-router';
import React, { useState } from 'react';
import { Alert, Pressable, ScrollView, StyleSheet, Text, TextInput, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');
import { register as registerRequest } from '@/lib/auth';

const STEPS = ['Data User', 'Hak Akses', 'Data Pegawai', 'Komponen Gaji'];

export default function EmployeeAddScreen() {
  const router = useRouter();
  const [activeStep] = useState(0);
  const [name, setName] = useState('');
  const [phone, setPhone] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [errorMessage, setErrorMessage] = useState<string | null>(null);

  const handleSubmit = async () => {
    if (loading) return;
    if (!name || !phone || !email || !password) {
      setErrorMessage('Semua field wajib diisi.');
      return;
    }
    setErrorMessage(null);
    setLoading(true);
    try {
      await registerRequest({
        name,
        phone,
        email,
        password,
        company_name: '',
        role: 'pegawai',
      });
      Alert.alert('Berhasil', 'Pegawai berhasil ditambahkan.');
      setName('');
      setPhone('');
      setEmail('');
      setPassword('');
      router.back();
    } catch (error) {
      if (error instanceof Error) {
        setErrorMessage(error.message);
      } else {
        setErrorMessage('Gagal menambahkan pegawai.');
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
          <Text style={styles.titleText}>Tambah Pegawai</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.stepsRow}>
          {STEPS.map((step, idx) => (
            <View
              key={step}
              style={[
                styles.stepPill,
                idx === activeStep && styles.stepPillActive,
                idx > activeStep && styles.stepPillInactive,
              ]}>
              <Text
                style={[
                  styles.stepText,
                  idx === activeStep && styles.stepTextActive,
                  idx > activeStep && styles.stepTextInactive,
                ]}>
                {step}
              </Text>
            </View>
          ))}
        </View>

        <View style={styles.field}>
          <Text style={styles.label}>Nama Pegawai</Text>
          <TextInput
            style={styles.input}
            value={name}
            onChangeText={setName}
            editable={!loading}
            placeholder="Nama Pegawai"
          />
        </View>
        <View style={styles.field}>
          <Text style={styles.label}>Telepon</Text>
          <TextInput
            style={styles.input}
            value={phone}
            onChangeText={setPhone}
            editable={!loading}
            keyboardType="phone-pad"
            placeholder="Nomor Telepon"
          />
        </View>
        <View style={styles.field}>
          <Text style={styles.label}>Email</Text>
          <TextInput
            style={styles.input}
            value={email}
            onChangeText={setEmail}
            editable={!loading}
            placeholder="Email"
          />
        </View>
        <View style={styles.field}>
          <Text style={styles.label}>Kata Sandi</Text>
          <View style={styles.passwordRow}>
            <TextInput
              style={[styles.input, styles.flex1]}
              value={password}
              onChangeText={setPassword}
              secureTextEntry
              editable={!loading}
              placeholder="Kata Sandi"
            />
            <MaterialCommunityIcons name="eye-off-outline" size={22} color="#7B88B2" />
          </View>
        </View>

        {errorMessage ? <Text style={styles.errorText}>{errorMessage}</Text> : null}
        <Pressable style={styles.saveButton} disabled={loading} onPress={handleSubmit}>
          <Text style={styles.saveText}>{loading ? 'Memproses...' : 'LANJUT'}</Text>
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
  stepsRow: {
    flexDirection: 'row',
    alignItems: 'center',
    flexWrap: 'wrap',
    gap: 6,
  },
  stepPill: {
    paddingHorizontal: 10,
    paddingVertical: 8,
    borderRadius: 10,
    backgroundColor: '#E7EBF5',
  },
  stepPillActive: {
    backgroundColor: '#0A4DA8',
  },
  stepPillInactive: {
    backgroundColor: '#DDE3F2',
  },
  stepText: { color: '#4B5C8B', fontWeight: '700', fontSize: 12 },
  stepTextActive: { color: '#fff' },
  stepTextInactive: { color: '#7B88B2' },
  field: { gap: 6 },
  label: { color: '#0B245A', fontWeight: '700' },
  input: {
    backgroundColor: '#F1F3F8',
    borderRadius: 12,
    paddingHorizontal: 12,
    paddingVertical: 10,
    color: '#0B245A',
  },
  errorText: {
    color: '#FF5A5F',
    fontWeight: '700',
    textAlign: 'center',
  },
  passwordRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
  },
  flex1: { flex: 1 },
  saveButton: {
    marginTop: 8,
    backgroundColor: '#0A6CFF',
    borderRadius: 10,
    paddingVertical: 14,
    alignItems: 'center',
  },
  saveText: { color: '#fff', fontWeight: '700', letterSpacing: 0.5 },
});
