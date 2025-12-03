import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useRouter } from 'expo-router';
import React from 'react';
import { Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');

export default function EmployeesScreen() {
  const router = useRouter();

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
        <Pressable
          style={styles.card}
          onPress={() => router.push('/account/staff/employee-add')}>
          <View style={styles.avatar}>
            <MaterialCommunityIcons name="account-circle" size={40} color="#0A4DA8" />
          </View>
          <View style={{ flex: 1 }}>
            <Text style={styles.name}>Dummy1</Text>
            <Text style={styles.meta}>dummy1@gmail.com</Text>
            <Text style={styles.meta}>Penempatan: -</Text>
            <Text style={styles.meta}>
              Bagian: <Text style={styles.link}>Produksi</Text>
            </Text>
          </View>
          <MaterialCommunityIcons name="dots-horizontal" size={22} color="#7B88B2" />
        </Pressable>
      </ScrollView>

      <Pressable style={styles.fab} onPress={() => router.push('/account/staff/employee-add')}>
        <MaterialCommunityIcons name="plus" size={28} color="#fff" />
      </Pressable>
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
  scrollContent: { padding: 14, paddingBottom: 80 },
  card: {
    backgroundColor: '#fff',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#E5E7EB',
    padding: 12,
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
    shadowColor: '#000',
    shadowOpacity: 0.08,
    shadowRadius: 8,
    shadowOffset: { width: 0, height: 2 },
    elevation: 3,
  },
  avatar: {
    width: 48,
    height: 48,
    borderRadius: 24,
    backgroundColor: '#E7F0FF',
    alignItems: 'center',
    justifyContent: 'center',
  },
  name: { color: '#0B245A', fontWeight: '700' },
  meta: { color: '#6B7A95', fontSize: 12 },
  link: { color: '#1D3FBF', fontWeight: '700' },
  fab: {
    position: 'absolute',
    bottom: 20,
    right: 20,
    width: 60,
    height: 60,
    borderRadius: 30,
    backgroundColor: '#2F78D3',
    alignItems: 'center',
    justifyContent: 'center',
    shadowColor: '#000',
    shadowOpacity: 0.2,
    shadowRadius: 10,
    shadowOffset: { width: 0, height: 4 },
    elevation: 8,
  },
});
