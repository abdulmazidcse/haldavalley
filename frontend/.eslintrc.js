module.exports = {
    env: {
      browser: true,
      es2021: true,
    },
    extends: [
      'eslint:recommended',
      'plugin:vue/vue3-essential', // or use 'plugin:vue/vue3-recommended'
    ],
    parserOptions: {
      ecmaVersion: 2021,
      sourceType: 'module',
      parser: 'vue-eslint-parser', // Ensure this parser is set for .vue files
    },
    plugins: [
      'vue',
    ],
    rules: {
      // Your custom rules here
    },
  };
  