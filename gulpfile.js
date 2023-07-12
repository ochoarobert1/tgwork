'use strict';

// Declare required dependencies
var gulp = require('gulp'),
	gulpif = require('gulp-if'),
	sass = require('gulp-sass')(require('node-sass')),
	browserSync = require('browser-sync').create(),
	concat = require('gulp-concat'),
	rename = require("gulp-rename"),
	uglify = require('gulp-uglify'),
	cleanCss = require('gulp-minify-css'),
	minimist = require('minimist');

// Declare variables for usage
var mainFolder = './themes/hello-elementor-child/',
	knownOptions = {
		string: 'env',
		default: { env: process.env.NODE_ENV || 'production' }
	},
	options = minimist(process.argv.slice(2), knownOptions);

// Workflow for Sass Files
gulp.task('sass-theme', function () {
	return gulp.src(mainFolder + 'src/scss/app.scss')
		.pipe(concat('app.scss'))
		.pipe(sass().on('error', sass.logError))
		.pipe(gulpif(options.env === 'production', cleanCss()))
		.pipe(gulp.dest(mainFolder + 'assets/css/'))
		.pipe(browserSync.stream());
});

gulp.task('sass-widgets', function () {
	return gulp.src(mainFolder + 'widgets/**/*.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(gulpif(options.env === 'production', cleanCss()))
		.pipe(rename(function (path) {
			return {
				dirname: '',
				basename: path.dirname,
				extname: ".css"
			}
		}))
		.pipe(gulp.dest(mainFolder + 'assets/css/elementor/'))
		.pipe(browserSync.stream());
});

// Workflow for JS Files
gulp.task('scripts-theme', function () {
	return gulp.src([
		'node_modules/bootstrap/dist/js/bootstrap.js',
		mainFolder + 'src/js/**/*.js'
	])
		.pipe(concat('app.js'))
		.pipe(gulpif(options.env === 'production', uglify()))
		.pipe(gulp.dest(mainFolder + 'assets/js/'))
		.pipe(browserSync.stream());
});

gulp.task('scripts-widgets', function () {
	return gulp.src(mainFolder + 'widgets/**/*.js')
		.pipe(gulpif(options.env === 'production', uglify()))
		.pipe(rename(function (path) {
			return {
				dirname: '',
				basename: path.dirname,
				extname: ".js"
			}
		}))
		.pipe(gulp.dest(mainFolder + 'assets/js/elementor/'))
		.pipe(browserSync.stream());
});

gulp.task('sass:watch', function () {
	gulp.watch(mainFolder + 'src/**/*.scss', gulp.series('sass-theme', 'sass-widgets', 'scripts-theme', 'scripts-widgets'));
});

gulp.task('default', gulp.series('sass-theme', 'sass-widgets', 'scripts-theme', 'scripts-widgets'));
