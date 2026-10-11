import os
from PIL import Image

os.makedirs('assets/images/collections', exist_ok=True)

# Helper to crop cleanly inside page boxes (avoiding borders)
def clean_crop(im, box, target_size=(320, 240)):
    cropped = im.crop(box)
    # Fit into target size with white background
    ratio = min(target_size[0] / cropped.width, target_size[1] / cropped.height)
    new_w = int(cropped.width * ratio)
    new_h = int(cropped.height * ratio)
    resized = cropped.resize((new_w, new_h), Image.Resampling.LANCZOS)
    
    canvas = Image.new('RGB', target_size, (255, 255, 255))
    offset = ((target_size[0] - new_w) // 2, (target_size[1] - new_h) // 2)
    canvas.paste(resized, offset)
    return canvas

# 1. Jobber Series Drills
p16 = Image.open('scratch/p16_drills_art.png')
im1 = clean_crop(p16, (440, 400, 1500, 2200))
im1.save('assets/images/collections/jobber_drills.jpg', quality=95)

# 2. Panther Series Drills (page 10)
p10 = Image.open('rendered_pages/page_10.png')
im2 = clean_crop(p10, (625, 260, 1070, 580))
im2.save('assets/images/collections/panther_drills.jpg', quality=95)

# 3. TiN Coated Drills (page 10 gold tool)
im3 = clean_crop(p10, (830, 310, 940, 580))
im3.save('assets/images/collections/tin_coated_drills.jpg', quality=95)

# 4. Ninja Cobalt Drills (page 11)
p11 = Image.open('rendered_pages/page_11.png')
im4 = clean_crop(p11, (625, 260, 1070, 580))
im4.save('assets/images/collections/ninja_cobalt.jpg', quality=95)

# 5. Forgeline Drills (page 15)
p15 = Image.open('rendered_pages/page_15.png')
im5 = clean_crop(p15, (105, 240, 550, 580))
im5.save('assets/images/collections/forgeline_drills.jpg', quality=95)

# 6. Hathyar Heavy Duty Drills (page 13)
p13 = Image.open('rendered_pages/page_13.png')
im6 = clean_crop(p13, (105, 250, 550, 580))
im6.save('assets/images/collections/hathyar_drills.jpg', quality=95)

# 7. Taper Shank Drills (page 10)
im7 = clean_crop(p10, (105, 240, 550, 580))
im7.save('assets/images/collections/taper_shank.jpg', quality=95)

# 8. HSS Milling Cutters (page 12)
p12 = Image.open('rendered_pages/page_12.png')
im8 = clean_crop(p12, (625, 250, 1070, 580))
im8.save('assets/images/collections/milling_cutters.jpg', quality=95)

# 9. Annular Cutters (page 15)
im9 = clean_crop(p15, (625, 250, 1070, 580))
im9.save('assets/images/collections/annular_cutters.jpg', quality=95)

# 10. HSS Reamers & Tool Bits (page 12)
im10 = clean_crop(p12, (105, 250, 550, 580))
im10.save('assets/images/collections/hss_tool_bits.jpg', quality=95)

print("Saved clean 320x240 collection cards JPGs!")
