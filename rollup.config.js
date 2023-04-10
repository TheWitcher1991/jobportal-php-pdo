import resolve from 'rollup-plugin-node-resolve'
import babel from 'rollup-plugin-babel'
import replace from 'rollup-plugin-replace'
import terser from '@rollup/plugin-terser'
import { sizeSnapshot } from 'rollup-plugin-size-snapshot'
import visualizer from 'rollup-plugin-visualizer'

// TODO: Добавить все скрипты

const format = process.env.FORMAT === 'cjs' ? 'cjs' : 'iife',
      dev = (process.env.NODE_ENV !== 'production'),
      tokens = {
        __CLOCKSELECTOR__: '.clock',
        __CLOCKINTERVAL__: 1000,
        __CLOCKFORMAT__: 'formatHMS'
}

const plugins = () => [
    resolve({
        ...tokens,
        extensions: ['.jsx', '.js'],
    }),
    babel({
        exclude: './node_modules/**'
    }),
    replace({
        'process.env.NODE_ENV': JSON.stringify('production'),
        __buildDate__: () => JSON.stringify(new Date()),
        __buildVersion: 15,
    }),
    sizeSnapshot(),
    terser({
        ecma: 2015,
        mangle: { toplevel: true },
        compress: {
            toplevel: true,
            drop_console: !dev,
            drop_debugger: !dev
        },
        output: { quote_style: 1 }
    }),
    visualizer()
]

export default [
    {
        input: 'src/index.js',
        output: [{ file: 'dist/index.module.js', format: format }],
        plugins: plugins(),
    },
    {
        input: 'src/profile.js',
        output: [{ file: 'dist/profile.module.js', format: format }],
        plugins: plugins(),
    },
    {
        input: 'src/auth.js',
        output: [{ file: 'dist/auth.module.js', format: format }],
        plugins: plugins(),
    },
    {
        input: 'src/chat.js',
        output: [{ file: 'dist/chat.module.js', format: format }],
        plugins: plugins(),
    }
];