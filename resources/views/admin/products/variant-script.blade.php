<script>
function productForm(initialIngredients, initialFaqs, initialVariants) {
    const uid = (prefix) => `${prefix}-${Date.now()}-${Math.random()}`;
    const toPreview = (path) => {
        if (!path) return '';
        if (/^https?:\/\//i.test(path)) return path;
        return `/media/public/${String(path).replace(/^\/+/, '')}`;
    };
    const ingredientTemplate = () => ({ uid: uid('ingredient'), name: '', existing_image: '', preview: '' });
    const faqTemplate = () => ({ uid: uid('faq'), question: '', answer: '' });
    const ritualTemplate = () => ({ uid: uid('ritual'), ritual: '', existing_image: '', preview: '' });
    const variantTemplate = (isDefault = false) => ({
        uid: uid('variant'),
        id: '',
        name: '',
        sku: '',
        price: '',
        discount_price: '',
        weight: '',
        brewing_rituals: [ritualTemplate()],
        is_default: isDefault,
        status: true,
    });

    return {
        ingredients: (initialIngredients || []).length ? initialIngredients.map((ingredient) => ({
            uid: uid('ingredient'),
            name: ingredient.name || '',
            existing_image: ingredient.image || ingredient.image_path || '',
            preview: toPreview(ingredient.image || ingredient.image_path || ''),
        })) : [ingredientTemplate()],
        faqs: (initialFaqs || []).length ? initialFaqs.map((faq) => ({
            uid: uid('faq'),
            question: faq.question || '',
            answer: faq.answer || '',
        })) : [faqTemplate()],
        variants: (initialVariants || []).length ? initialVariants.map((variant, index) => ({
            uid: uid('variant'),
            id: variant.id || '',
            name: variant.name || variant.variant_name || '',
            sku: variant.sku || '',
            price: variant.price || '',
            discount_price: variant.discount_price || variant.compare_price || '',
            weight: variant.weight || '',
            brewing_rituals: (variant.brewing_rituals || []).length ? variant.brewing_rituals.map((ritual) => ({
                uid: uid('ritual'),
                ritual: ritual.ritual || ritual.text || '',
                existing_image: ritual.image || ritual.image_path || '',
                preview: toPreview(ritual.image || ritual.image_path || ''),
            })) : [ritualTemplate()],
            is_default: typeof variant.is_default === 'undefined' ? index === 0 : Boolean(Number(variant.is_default) || variant.is_default),
            status: typeof variant.status === 'undefined' ? true : Boolean(Number(variant.status) || variant.status),
        })) : [variantTemplate(true)],
        addIngredient() { this.ingredients.push(ingredientTemplate()); },
        removeIngredient(index) { this.ingredients.length === 1 ? this.ingredients[index] = ingredientTemplate() : this.ingredients.splice(index, 1); },
        addFaq() { this.faqs.push(faqTemplate()); },
        removeFaq(index) { this.faqs.length === 1 ? this.faqs[index] = faqTemplate() : this.faqs.splice(index, 1); },
        addVariant() { this.variants.push(variantTemplate(this.variants.length === 0)); },
        removeVariant(index) {
            if (this.variants.length === 1) { alert('At least one variant is required.'); return; }
            const wasDefault = this.variants[index].is_default;
            this.variants.splice(index, 1);
            if (wasDefault && this.variants.length) this.setDefaultVariant(0);
        },
        setDefaultVariant(index) { this.variants.forEach((variant, variantIndex) => variant.is_default = variantIndex === index); },
        addRitual(index) { this.variants[index].brewing_rituals.push(ritualTemplate()); },
        removeRitual(index, ritualIndex) {
            const rituals = this.variants[index].brewing_rituals;
            rituals.length === 1 ? rituals[ritualIndex] = ritualTemplate() : rituals.splice(ritualIndex, 1);
        },
    }
}
</script>
