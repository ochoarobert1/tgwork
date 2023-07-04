const path = require('path');
const glob = require('glob');
const TerserPlugin = require("terser-webpack-plugin");

const entries = glob.sync(__dirname + '/themes/hello-elementor-child/widgets/**/*.scss').toString();

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