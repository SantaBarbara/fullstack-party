// http://eslint.org/docs/user-guide/configuring

module.exports = {
    root: true,
    parserOptions: {
        parser: 'babel-eslint',
        sourceType: 'module'
    },
    env: {
        amd: true,
        browser: true,
        commonjs: true,
        es6: true,
        jquery: true,
        node: true
    },
    extends: [
        'airbnb-base',
        'plugin:vue/recommended'
    ],
    // required to lint *.vue files
    plugins: [
        'import',
        'html'
    ],
    // check if imports actually resolve
    settings: {
        'import/resolver': {
            webpack: {
                config: 'node_modules/laravel-mix/setup/webpack.config.js'
            }
        }
    },
    // add your custom rules here
    rules: {
        'class-methods-use-this': 0,
        'comma-dangle': 0,
        // don't require .vue extension when importing
        'import/extensions': ['error', 'always', {
            'js': 'never',
            'vue': 'never'
        }],
        // allow optionalDependencies
        'import/no-extraneous-dependencies': ['error', {
            'optionalDependencies': []
        }],
        indent: ["error", 4],
        // allow debugger during development
        'no-debugger': process.env.NODE_ENV === 'production' ? 2 : 0,
        camelcase: 0,
        "no-undef": 0,
        "no-shadow": 0,
        "no-param-reassign": 0,
        "semi": 0,
        "import/extensions": 0,
        //"space-before-function-paren": 0
    }
}
