import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Image } from 'expo-image';
import { LinearGradient } from 'expo-linear-gradient';
import { useRouter } from 'expo-router';
import React, { useState } from 'react';
import { Pressable, ScrollView, StyleSheet, Text, TextInput, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const logoSource = require('@/assets/images/logo.png');

type Level = 'parent' | 'child';

export default function ChartOfAccountAddScreen() {
  const router = useRouter();
  const [level, setLevel] = useState<Level>('parent');

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
          <Text style={styles.titleText}>Chart of Account: Tambah</Text>
        </Pressable>
      </View>

      <ScrollView contentContainerStyle={styles.form} showsVerticalScrollIndicator={false}>
        <LabeledInput label="Kode Akun" placeholder="Masukkan kode akun" />
        <LabeledInput label="Nama Akun" placeholder="Masukkan nama akun" />

        <Text style={styles.label}>Level</Text>
        <View style={styles.radioGroup}>
          <RadioItem
            label="Parent"
            selected={level === 'parent'}
            onPress={() => setLevel('parent')}
            color="#FF8A00"
          />
          <RadioItem
            label="Child"
            selected={level === 'child'}
            onPress={() => setLevel('child')}
            color="#0A4DA8"
          />
        </View>

        <LabeledInput label="Jenis Akun" placeholder="Masukkan jenis akun" />
        <LabeledInput
          label="Keterangan Akun"
          placeholder="Masukkan keterangan"
          multiline
          style={styles.textarea}
        />

        <Pressable style={styles.submitButton}>
          <Text style={styles.submitText}>SIMPAN</Text>
        </Pressable>
      </ScrollView>
    </SafeAreaView>
  );
}

const LabeledInput = ({
  label,
  placeholder,
  style,
  ...rest
}: {
  label: string;
  placeholder?: string;
  style?: any;
} & React.ComponentProps<typeof TextInput>) => (
  <View style={styles.field}>
    <Text style={styles.label}>{label}</Text>
    <TextInput
      placeholder={placeholder}
      placeholderTextColor="rgba(10,45,120,0.35)"
      style={[styles.input, style]}
      {...rest}
    />
  </View>
);

const RadioItem = ({
  label,
  selected,
  onPress,
  color,
}: {
  label: string;
  selected: boolean;
  onPress: () => void;
  color: string;
}) => (
  <Pressable style={styles.radioItem} onPress={onPress}>
    <View style={[styles.radioOuter, { borderColor: color }]}>
      {selected ? <View style={[styles.radioInner, { backgroundColor: color }]} /> : null}
    </View>
    <Text style={styles.radioLabel}>{label}</Text>
  </Pressable>
);

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
  form: {
    paddingHorizontal: 16,
    paddingVertical: 16,
    gap: 16,
  },
  field: {
    gap: 8,
  },
  label: {
    color: '#0B245A',
    fontWeight: '600',
  },
  input: {
    backgroundColor: '#F1F3F8',
    borderRadius: 18,
    paddingHorizontal: 14,
    paddingVertical: 12,
    color: '#0B245A',
  },
  textarea: {
    height: 80,
    textAlignVertical: 'top',
  },
  radioGroup: {
    gap: 8,
  },
  radioItem: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
  },
  radioOuter: {
    width: 22,
    height: 22,
    borderRadius: 11,
    borderWidth: 2,
    alignItems: 'center',
    justifyContent: 'center',
  },
  radioInner: {
    width: 10,
    height: 10,
    borderRadius: 5,
  },
  radioLabel: {
    color: '#0B245A',
    fontWeight: '600',
  },
  submitButton: {
    marginTop: 10,
    backgroundColor: '#0A6CFF',
    borderRadius: 10,
    paddingVertical: 14,
    alignItems: 'center',
  },
  submitText: {
    color: '#fff',
    fontWeight: '700',
    letterSpacing: 0.5,
  },
});
