import pdfplumber
import json
import re

pdf_path = 'ITM- Price List -04-2026 -.pdf'

rows_data = []

# Pages 17 to 22 (1-indexed)
start_page = 17
end_page = 22

def clean_cell(val):
    if val is None:
        return ""
    # remove strange control chars or newlines
    v = str(val).replace('\n', ' ').strip()
    return v

with pdfplumber.open(pdf_path) as pdf:
    for page_num in range(start_page, end_page + 1):
        page = pdf.pages[page_num - 1]
        tables = page.extract_tables()
        print(f"Page {page_num}: found {len(tables)} table(s)")
        
        for table in tables:
            header_passed = False
            for r_idx, row in enumerate(table):
                cleaned = [clean_cell(c) for c in row]
                
                # Check if this is the header row
                if 'MM' in cleaned or 'PRICE PER 10 PCS' in "".join(cleaned):
                    continue
                if not any(cleaned):
                    continue
                
                # Ensure row has at least 10 items
                while len(cleaned) < 10:
                    cleaned.append("")
                
                mm_val = cleaned[0]
                inch_val = cleaned[1]
                dg_val = cleaned[2]
                itm_std_val = cleaned[3]
                itm_tin_val = cleaned[4]
                panther_val = cleaned[5]
                ninja_val = cleaned[6]
                forgeline_val = cleaned[7]
                hathyar_val = cleaned[8]
                moq_val = cleaned[9]
                
                # Check if mm looks like a valid diameter (number with optional decimal)
                # Sometimes footnote or page header might appear
                if not re.match(r'^\d+(\.\d+)?$', mm_val):
                    print(f"Skipping non-data row on page {page_num}: {cleaned}")
                    continue
                
                def parse_price(p):
                    p = p.strip()
                    if not p or p == '-' or p == '—' or p == '–':
                        return None
                    # Clean commas or extra chars
                    p_clean = re.sub(r'[^\d.]', '', p)
                    if not p_clean:
                        return None
                    try:
                        return float(p_clean)
                    except:
                        return None

                def parse_moq(m):
                    m = m.strip()
                    m_clean = re.sub(r'[^\d]', '', m)
                    if m_clean:
                        return int(m_clean)
                    return None

                row_obj = {
                    "page": page_num,
                    "mm": mm_val,
                    "diameter_float": float(mm_val),
                    "inch": inch_val if inch_val else None,
                    "dg": dg_val if dg_val else None,
                    "itm_std": parse_price(itm_std_val),
                    "itm_std_tin": parse_price(itm_tin_val),
                    "panther": parse_price(panther_val),
                    "ninja": parse_price(ninja_val),
                    "forgeline": parse_price(forgeline_val),
                    "hathyar": parse_price(hathyar_val),
                    "moq": parse_moq(moq_val)
                }
                rows_data.append(row_obj)

print(f"Total rows extracted: {len(rows_data)}")
if rows_data:
    print("First row:", rows_data[0])
    print("Middle row (sample):", rows_data[len(rows_data)//2])
    print("Last row:", rows_data[-1])

# Save to JSON
with open('jobber_series_data.json', 'w', encoding='utf-8') as f:
    json.dump(rows_data, f, indent=2)

print("Saved jobber_series_data.json successfully.")
