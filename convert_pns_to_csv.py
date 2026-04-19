import json
import csv

src = 'storage/app/private/exports/pns.json'
dst = 'storage/app/private/exports/pns.csv'

with open(src, 'r', encoding='utf-8') as f:
    data = json.load(f)

if not data:
    raise SystemExit('No records to export.')

keys = list(data[0].keys())

with open(dst, 'w', encoding='utf-8', newline='') as f:
    writer = csv.DictWriter(f, fieldnames=keys)
    writer.writeheader()
    writer.writerows(data)

print('Wrote {} records to {}'.format(len(data), dst))
