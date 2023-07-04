const path = require('path');
const glob = require('glob');
const TerserPlugin = require("terser-webpack-plugin");

const entries = glob.sync(__dirname + '/themes/hello-elementor-child/src/scss/elementor/*.scss').toString();

module.exports = {
	mode: 'development',
	entry: [
		__dirname + '/themes/hello-elementor-child/src/js/app.js',
		__dirname + '/themes/hello-elementor-child/src/scss/app.scss',
		entries
	],
	output: {
		path: path.resolve(__dirname, 'themes/hello-elementor-child/assets'),
		filename: 'js/app.min.js',
		clean: true
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: [],
			}, {
				test: /\.css$/,
				use: ['style-loader', 'css-loader']
			}, {
				test: /\.scss$/,
				exclude: /node_modules/,
				use: [
					{
						loader: 'file-loader',
						options: {
							outputPath: (url, resourcePath, context) => {
								if (/\\elementor\\/.test(resourcePath)) {
									return `css/elementor/${url}`;
								}
								return `css/${url}`;
							},
							useRelativePath: true,
							name: '[name].css'
						}
					},
					'sass-loader'
				],
			}
		]
	},
	optimization: {
		minimize: true,
		minimizer: [new TerserPlugin({
			extractComments: true,
		})],
	},
};