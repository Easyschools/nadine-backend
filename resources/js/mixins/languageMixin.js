import en from '../../lang/en';
import ar from '../../lang/ar';

export default {
  data() {
    return {
      currentLanguage: localStorage.getItem('language') || 'en', // Use 'en' if not found in Local Storage

      languages: {
        en,
        ar,
      },
    };
  },
  computed: {
    translations() {
      return this.languages[this.currentLanguage];
    },
  },
  methods: {
    switchLanguage(language) {
      this.currentLanguage = language; // Update the language in the mixin
      this.$store.dispatch('setLanguage', language); // Dispatch the "setLanguage" action in Vuex
      localStorage.setItem('language', language); // Save language to local storage
      location.reload();
    },
  },
};
