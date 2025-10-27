for line in range(1,5):
    for adjust in range(1,5):
        if line + adjust == 5:
            print('Y', end='')
        else:
            print('X', end='')
    print()

try:
    s = input("Masukkan angka Anda (1-10, default 10): ").strip()
    n = 10 if s == "" else max(1, min(10, int(s)))
except Exception:
    n = 10

for i in range(1, n + 1):
    print('*' * i)

pendapatan = int(input('Masukkan pendapatan anda: '))
status_pernikahan = input('Apakah anda sudah kawin? (ya/tidak): ').lower()
if status_pernikahan == 'ya':
    anak = int(input('Berapa jumlah anak anda: '))
    tunjangan_kawin = pendapatan*(10/100)
    tunjangan_anak = pendapatan * (2/100*anak)
    print(f'Tunjangan kawin: {tunjangan_kawin}\nTunjangan anak: {tunjangan_anak}\nTotal tunjangan: {tunjangan_anak+tunjangan_kawin}\n Pendapatan: {tunjangan_anak+tunjangan_kawin+pendapatan}')
else:
    print(f'Pendapatan: {pendapatan}')