const path = require('path');
const glob = require('glob');
const TerserPlugin = require("terser-webpack-plugin");

const entriesScss = glob.sync(__dirname + '/themes/hello-elementor-child/widgets/**/*.scss').toString();
const entriesJS = glob.sync(__dirname + '/themes/hello-elementor-child/widgets/**/*.js').toString();

module.exports = {
	mode: 'development',
	stats: 'minimal',
	entry: [
		__dirname + '/themes/hello-elementor-child/src/js/app.js',
		__dirname + '/themes/hello-elementor-child/src/scss/app.scss',
		entriesScss,
		entriesJS
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
				use: [
					{
						loader: 'file-loader',
						options: {
							outputPath: (url, resourcePath) => {
								if (/\\widgets\\/.test(resourcePath)) {
									return `js/elementor/${url}`;
								}
								return `js/${url}`;
							},
							useRelativePath: true,
							name(resourcePath) {
								if (/\\widgets\\/.test(resourcePath)) {
									var widgetFolder = resourcePath.split('\\widgets\\');
									var widgetName = widgetFolder[1].split('\\');
									return widgetName[0] + '.js';
								}
								return '[name].js';
							},
						}
					}
				],
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
							outputPath: (url, resourcePath) => {
								if (/\\widgets\\/.test(resourcePath)) {
									return `css/elementor/${url}`;
								}
								return `css/${url}`;
							},
							useRelativePath: true,
							name(resourcePath) {
								if (/\\widgets\\/.test(resourcePath)) {
									var widgetFolder = resourcePath.split('\\widgets\\');
									var widgetName = widgetFolder[1].split('\\');
									return widgetName[0] + '.css';
								}
								return '[name].css';
							},
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
			extractComments: false,
		})],
	},
};