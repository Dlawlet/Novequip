#!/bin/bash
# Script to download sample product images for NovEquip store
# These images will be used for the sample products

echo "Creating product images directory..."
mkdir -p wp-content/uploads/product-images

# Define arrays of image URLs for each category
# Using placeholder images from pixabay and unsplash which are free for commercial use

# Power Tools images
POWER_TOOLS=(
  "https://cdn.pixabay.com/photo/2015/12/02/15/04/drill-1073384_1280.jpg"
  "https://cdn.pixabay.com/photo/2013/06/14/14/24/drill-139057_1280.jpg"
  "https://cdn.pixabay.com/photo/2015/07/11/14/53/plumbing-840835_1280.jpg"
  "https://cdn.pixabay.com/photo/2017/04/04/17/26/hacksaw-2202309_1280.jpg"
)

# Hand Tools images
HAND_TOOLS=(
  "https://cdn.pixabay.com/photo/2017/06/15/13/27/tools-2405958_1280.jpg"
  "https://cdn.pixabay.com/photo/2015/07/28/20/55/tools-864983_1280.jpg"
  "https://cdn.pixabay.com/photo/2016/01/13/22/48/craft-1139033_1280.jpg"
  "https://cdn.pixabay.com/photo/2017/12/28/16/18/tools-3045226_1280.jpg"
)

# Safety Equipment images
SAFETY_EQUIPMENT=(
  "https://cdn.pixabay.com/photo/2017/05/10/19/29/helmet-2301505_1280.jpg"
  "https://cdn.pixabay.com/photo/2019/03/16/06/48/industry-4058083_1280.jpg"
  "https://cdn.pixabay.com/photo/2016/02/19/10/59/helmet-1209169_1280.jpg"
  "https://cdn.pixabay.com/photo/2016/09/15/17/45/gloves-1672265_1280.jpg"
)

# Measuring Tools images
MEASURING_TOOLS=(
  "https://cdn.pixabay.com/photo/2016/03/18/15/54/measure-1265130_1280.jpg"
  "https://cdn.pixabay.com/photo/2016/04/12/22/35/waterpass-1325686_1280.jpg"
  "https://cdn.pixabay.com/photo/2017/08/07/22/57/caliper-2608858_1280.jpg"
  "https://cdn.pixabay.com/photo/2016/03/01/05/37/carpenter-1230013_1280.jpg"
)

# Function to download images for a category
download_category_images() {
  local category_name="$1"
  local image_array=("${!2}")
  local category_dir="wp-content/uploads/product-images/${category_name// /-}"
  
  echo "Downloading ${category_name} images..."
  mkdir -p "$category_dir"
  
  local count=1
  for url in "${image_array[@]}"; do
    local filename="${category_dir}/${category_name// /-}-${count}.jpg"
    echo "  Downloading: ${url} -> ${filename}"
    curl -s -L "$url" -o "$filename"
    let count++
  done
  
  echo "Completed ${category_name} downloads"
  echo ""
}

# Download images for each category
download_category_images "Power Tools" POWER_TOOLS[@]
download_category_images "Hand Tools" HAND_TOOLS[@]
download_category_images "Safety Equipment" SAFETY_EQUIPMENT[@]
download_category_images "Measuring Tools" MEASURING_TOOLS[@]

echo "All product images have been downloaded successfully!"
echo "Images are stored in wp-content/uploads/product-images/"
echo ""
echo "Next steps:"
echo "1. Import these images when creating products in WooCommerce"
echo "2. Use sample-products.csv to import products with WooCommerce importer"
