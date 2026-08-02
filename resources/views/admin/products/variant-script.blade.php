<script>
function productForm(initialFaqs, initialBrewingRituals, initialVariants) {
    const uid = (prefix) => `${prefix}-${Date.now()}-${Math.random()}`;
    const faqTemplate = () => ({ uid: uid('faq'), question: '', answer: '' });
    const ritualTemplate = () => ({ uid: uid('ritual'), label: '', value: '' });
    const normalizeRitualGroup = (rituals = []) => {
        const items = (rituals || []).map((ritual) => ({
            uid: uid('ritual'),
            label: ritual.label || '',
            value: ritual.value || ritual.ritual || ritual.text || ritual.items?.[0]?.text || '',
        }));

        return items.length ? items : [ritualTemplate()];
    };
    const normalizeRituals = (rituals = []) => {
        if (!Array.isArray(rituals) && rituals && typeof rituals === 'object') {
            return {
                hot_brew: normalizeRitualGroup(rituals.hot_brew || []),
                iced_brew: normalizeRitualGroup(rituals.iced_brew || []),
                note: rituals.note || '',
            };
        }

        return {
            hot_brew: normalizeRitualGroup((rituals || []).slice(0, 1)),
            iced_brew: normalizeRitualGroup((rituals || []).slice(1, 2)),
            note: '',
        };
    };
    const variantTemplate = (isDefault = false) => ({
        uid: uid('variant'),
        id: '',
        name: '',
        sku: '',
        price: '',
        discount_price: '',
        weight: '',
        product_dimension: '',
        item_form: '',
        is_default: isDefault,
        status: true,
    });

    return {
        faqs: (initialFaqs || []).length ? initialFaqs.map((faq) => ({
            uid: uid('faq'),
            question: faq.question || '',
            answer: faq.answer || '',
        })) : [faqTemplate()],
        brewing_rituals: normalizeRituals(initialBrewingRituals || []),
        variants: (initialVariants || []).length ? initialVariants.map((variant, index) => ({
            uid: uid('variant'),
            id: variant.id || '',
            name: variant.name || variant.variant_name || '',
            sku: variant.sku || '',
            price: variant.price || '',
            discount_price: variant.discount_price || variant.compare_price || '',
            weight: variant.weight || '',
            product_dimension: variant.product_dimension || '',
            item_form: variant.item_form || '',
            is_default: typeof variant.is_default === 'undefined' ? index === 0 : Boolean(Number(variant.is_default) || variant.is_default),
            status: typeof variant.status === 'undefined' ? true : Boolean(Number(variant.status) || variant.status),
        })) : [variantTemplate(true)],
        addFaq() { this.faqs.push(faqTemplate()); },
        removeFaq(index) { this.faqs.length === 1 ? this.faqs[index] = faqTemplate() : this.faqs.splice(index, 1); },
        addVariant() { this.variants.push(variantTemplate(this.variants.length === 0)); },
        addBrewingRitual(group) { this.brewing_rituals[group].push(ritualTemplate()); },
        removeBrewingRitual(group, ritualIndex) {
            const rituals = this.brewing_rituals[group];
            rituals.length === 1 ? rituals[ritualIndex] = ritualTemplate() : rituals.splice(ritualIndex, 1);
        },
        removeVariant(index) {
            if (this.variants.length === 1) { alert('At least one variant is required.'); return; }
            const wasDefault = this.variants[index].is_default;
            this.variants.splice(index, 1);
            if (wasDefault && this.variants.length) this.setDefaultVariant(0);
        },
        setDefaultVariant(index) { this.variants.forEach((variant, variantIndex) => variant.is_default = variantIndex === index); },
    }
}
</script>
