import os
from PIL import Image

# Polish drills showcase
p16_art = Image.open('scratch/p16_drills_art.png')
# Drills showcase: from x=240 to x=1550, y=260 to y=2250 (avoiding left DRILLS badge and top badge)
drills_clean = p16_art.crop((240, 260, 1550, 2220))
drills_clean.save('assets/images/products/hss_jobber_drills_showcase.png')
print('Polished hss_jobber_drills_showcase.png')

# Also let's crop the parallel shank drill specifically (e.g. the 2nd one or 5th one with straight cylindrical shank!)
# Notice drill 2 (from left: parallel shank long/jobber) x=560 to 720, y=270 to 1850
drill_parallel = p16_art.crop((550, 260, 730, 1900))
drill_parallel.save('assets/images/products/drill_parallel_shank_single.png')

# Drill 5 (jobber / stub with straight parallel shank): x=1020 to 1250, y=1100 to 1900
drill_jobber = p16_art.crop((1000, 1100, 1260, 1900))
drill_jobber.save('assets/images/products/drill_jobber_parallel.png')

print('Individual drill assets saved.')
