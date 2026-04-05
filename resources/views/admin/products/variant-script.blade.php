<script>
function productForm(initialVariants, initialFeatures) {
    const normalizeRituals = (rituals) => (rituals || []).length
        ? (rituals || []).map((ritual, index) => ({
            uid: ritual.id || `ritual-${Date.now()}-${index}`,
            icon: ritual.icon || '',
            text: ritual.text || '',
        }))
        : [{ uid: `ritual-${Date.now()}-0`, icon: '', text: '' }];

    const normalizeImages = (images) => (images || []).length
        ? (images || []).map((image, index) => ({
            uid: image.id || `image-${Date.now()}-${index}`,
            sort_order: image.sort_order ?? index,
            is_primary: Boolean(Number(image.is_primary) || image.is_primary),
        }))
        : [{ uid: `image-${Date.now()}-0`, sort_order: 0, is_primary: true }];

    const variants = (initialVariants || []).map((variant, index) => ({
        uid: variant.id || `variant-${Date.now()}-${index}`,
        id: variant.id || '',
        variant_name: variant.variant_name || '',
        size: variant.size || '',
        color: variant.color || '',
        sku: variant.sku || '',
        price: variant.price || '',
        stock: variant.stock ?? 0,
        weight: variant.weight || '',
        dimensions: variant.dimensions || '',
        net_weight: variant.net_weight || '',
        tags_raw: variant.tags_raw || '',
        brewing_rituals: normalizeRituals(variant.brewing_rituals),
        images: normalizeImages(variant.images),
        is_default: typeof variant.is_default === 'undefined' ? index === 0 : Boolean(Number(variant.is_default) || variant.is_default),
        status: typeof variant.status === 'undefined' ? true : Boolean(Number(variant.status) || variant.status),
    }));

    return {
        features: (initialFeatures || []).map((feature, index) => ({
            uid: feature.id || `feature-${Date.now()}-${index}`,
            icon: feature.icon || '',
            text: feature.text || '',
        })),
        variants,
        addFeature() {
            this.features.push({ uid: `feature-${Date.now()}-${Math.random()}`, icon: '', text: '' });
        },
        removeFeature(index) {
            if (this.features.length === 1) {
                this.features[index] = { uid: `feature-${Date.now()}-${Math.random()}`, icon: '', text: '' };
                return;
            }
            this.features.splice(index, 1);
        },
        addVariant() {
            this.variants.push({
                uid: `variant-${Date.now()}-${Math.random()}`,
                id: '',
                variant_name: '',
                size: '',
                color: '',
                sku: '',
                price: '',
                stock: 0,
                weight: '',
                dimensions: '',
                net_weight: '',
                tags_raw: '',
                brewing_rituals: [{ uid: `ritual-${Date.now()}-${Math.random()}`, icon: '', text: '' }],
                images: [{ uid: `image-${Date.now()}-${Math.random()}`, sort_order: 0, is_primary: true }],
                is_default: this.variants.length === 0,
                status: true,
            });
            if (this.variants.length === 1) {
                this.variants[0].is_default = true;
            }
        },
        removeVariant(index) {
            if (this.variants.length === 1) {
                alert('At least one variant is required.');
                return;
            }
            const removed = this.variants[index];
            this.variants.splice(index, 1);
            if (removed.is_default && this.variants.length) {
                this.variants.forEach((variant, variantIndex) => {
                    variant.is_default = variantIndex === 0;
                });
            }
        },
        setDefaultVariant(index) {
            this.variants.forEach((variant, variantIndex) => {
                variant.is_default = variantIndex === index;
            });
        },
        addRitual(index) {
            this.variants[index].brewing_rituals.push({ uid: `ritual-${Date.now()}-${Math.random()}`, icon: '', text: '' });
        },
        removeRitual(index, ritualIndex) {
            if (this.variants[index].brewing_rituals.length === 1) {
                this.variants[index].brewing_rituals[ritualIndex] = { uid: `ritual-${Date.now()}-${Math.random()}`, icon: '', text: '' };
                return;
            }
            this.variants[index].brewing_rituals.splice(ritualIndex, 1);
        },
        addImage(index) {
            const images = this.variants[index].images;
            images.push({ uid: `image-${Date.now()}-${Math.random()}`, sort_order: images.length, is_primary: images.length === 0 });
        },
        removeImage(index, imageIndex) {
            const images = this.variants[index].images;
            if (images.length === 1) {
                images[imageIndex] = { uid: `image-${Date.now()}-${Math.random()}`, sort_order: 0, is_primary: true };
                return;
            }
            const wasPrimary = images[imageIndex].is_primary;
            images.splice(imageIndex, 1);
            if (wasPrimary && images.length) {
                images.forEach((image, idx) => {
                    image.is_primary = idx === 0;
                });
            }
        },
        setPrimaryImage(index, imageIndex) {
            this.variants[index].images.forEach((image, idx) => {
                image.is_primary = idx === imageIndex;
            });
        }
    }
}
</script>
