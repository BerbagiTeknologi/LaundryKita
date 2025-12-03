import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useRouter } from 'expo-router';
import React from 'react';
import { Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');

const GROUPS = [
  { code: 'PRDKS', name: 'Produksi' },
  { code: 'KURIR', name: 'Kurir' },
];

export default function StaffGroupsScreen() {
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
          <Text style={styles.titleText}>Golongan Pegawai</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.listCard}>
          {GROUPS.map((item, idx) => (
            <View key={item.code}>
              <View style={styles.row}>
                <Text style={styles.code}>{item.code}</Text>
                <Text style={styles.sep}>|</Text>
                <Text style={styles.name}>{item.name}</Text>
                <MaterialCommunityIcons name="dots-horizontal" size={22} color="#7B88B2" />
              </View>
              {idx < GROUPS.length - 1 ? <View style={styles.divider} /> : null}
            </View>
          ))}
        </View>
      </ScrollView>

      <Pressable style={styles.fab}>
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
  listCard: {
    backgroundColor: '#fff',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#E5E7EB',
    paddingHorizontal: 12,
    paddingVertical: 8,
  },
  row: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
    paddingVertical: 12,
  },
  code: { color: '#1D3FBF', fontWeight: '800' },
  sep: { color: '#6B7A95', fontWeight: '700' },
  name: { flex: 1, color: '#0B245A', fontWeight: '700' },
  divider: { borderBottomWidth: 1, borderBottomColor: '#E9ECF2' },
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
