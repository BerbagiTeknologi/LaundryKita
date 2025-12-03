import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useLocalSearchParams, useRouter } from 'expo-router';
import React from 'react';
import { Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');

export default function OutletPickupHoursScreen() {
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
          <Text style={styles.titleText}>Jam Antar Jemput</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.placeholderCard}>
          <Text style={styles.placeholderTitle}>Belum ada data antar jemput</Text>
          <Text style={styles.placeholderText}>
            Atur jam antar jemput untuk {userName ? userName : 'outlet kamu'} di sini.
          </Text>
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
  scrollContent: { padding: 16, paddingBottom: 40 },
  placeholderCard: {
    backgroundColor: '#fff',
    borderRadius: 12,
    borderWidth: 1,
    borderColor: '#E5E7EB',
    padding: 16,
    gap: 8,
  },
  placeholderTitle: { fontWeight: '700', color: '#0B245A' },
  placeholderText: { color: '#4B5C8B', lineHeight: 20 },
});
