# Use some google shenanigary to download image sets for use during development
# DM 2021-02-12
# Reference https://github.com/RiddlerQ/simple_image_download

import sys
import os
import pip

try:
    from simple_image_download import simple_image_download as simp
except:
    pip.main(['install','simple_image_download'])
    from simple_image_download import simple_image_download as simp

try:
    query = sys.argv[1]
except:
    query = "tea cup"

try:
    limit = int(sys.argv[2])
except:
    limit = 5

print(os.getcwd())
os.chdir("ML_Core/User_Images")
print(os.getcwd())

response = simp.simple_image_download

response().download(query,limit)
