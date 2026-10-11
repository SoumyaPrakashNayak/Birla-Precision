import os
from PIL import Image

os.makedirs('assets/images/brand', exist_ok=True)
os.makedirs('assets/images/products', exist_ok=True)
os.makedirs('assets/images/hero', exist_ok=True)
os.makedirs('assets/images/tiles', exist_ok=True)

# 1. Birla Precision main logo
# From scratch/p1_logo_candidate.png
im_p1_logo = Image.open('scratch/p1_logo_candidate.png')
# Crop tightly around logo
# Find non-white bbox
bg = Image.new('RGB', im_p1_logo.size, (255, 255, 255))
from PIL import ImageChops
diff = ImageChops.difference(im_p1_logo.convert('RGB'), bg)
bbox = diff.getbbox()
if bbox:
    # pad slightly
    pad = 10
    crop_box = (max(0, bbox[0]-pad), max(0, bbox[1]-pad), min(im_p1_logo.width, bbox[2]+pad), min(im_p1_logo.height, bbox[3]+pad))
    im_p1_logo.crop(crop_box).save('assets/images/brand/birla_precision_logo.png')
    print('Saved assets/images/brand/birla_precision_logo.png')

# 2. Dagger Brand logo, Panther, Ninja, Forgeline, Hathyar from p150_top.png
p150_top = Image.open('scratch/p150_top.png')
w, h = p150_top.size
print('P150 top size:', w, h)

# Let's crop individual brand cards from p150_top
# First row of brands: Dagger, Panther, Ninja, Forgeline, Hathyar
# Based on p150_top image:
# Y range for row 1: approximately y=580 to y=880
# Columns: 
# Dagger Brand: x=50 to x=320
# Panther: x=340 to x=640
# Ninja: x=660 to x=940
# Forgeline: x=960 to x=1220
# Hathyar: x=1240 to x=1680

dagger_crop = p150_top.crop((60, 580, 320, 880))
dagger_crop.save('assets/images/brand/dagger_brand_logo.png')

panther_crop = p150_top.crop((340, 580, 640, 880))
panther_crop.save('assets/images/brand/panther_logo.png')

ninja_crop = p150_top.crop((680, 580, 940, 880))
ninja_crop.save('assets/images/brand/ninja_logo.png')

forgeline_crop = p150_top.crop((970, 580, 1220, 880))
forgeline_crop.save('assets/images/brand/forgeline_logo.png')

hathyar_crop = p150_top.crop((1230, 580, 1690, 880))
hathyar_crop.save('assets/images/brand/hathyar_logo.png')

print('Saved variant brand logos!')

# 3. Product Drills imagery
# From scratch/p16_drills_art.png
p16_art = Image.open('scratch/p16_drills_art.png')
# Pedestal + Drills: from about y=200 to y=2300, x=80 to x=1550
drills_hero = p16_art.crop((80, 200, 1550, 2250))
drills_hero.save('assets/images/products/hss_jobber_drills_showcase.png')
print('Saved assets/images/products/hss_jobber_drills_showcase.png')

# Also single/group drill crop from page 10
p10_img = Image.open('rendered_pages/page_10.png')
# left box drills
p10_drills = p10_img.crop((80, 150, 550, 570))
p10_drills.save('assets/images/products/hss_twist_drills_group.png')
print('Saved assets/images/products/hss_twist_drills_group.png')
