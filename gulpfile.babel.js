import gulp from 'gulp';
import sass from 'gulp-sass';
import plumber from 'gulp-plumber';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import browserSync from 'browser-sync';
import sourcemaps from 'gulp-sourcemaps';
import browserify from 'browserify';
import babelify from 'babelify';
import buffer from 'vinyl-buffer';
import source from 'vinyl-source-stream';
import concatJS from 'gulp-concat';
import uglify from 'gulp-uglify';

const server = browserSync.create();

let postcssPlugins = [
	autoprefixer({
		browsers: 'last 2 versions'
	}),
	cssnano({
		core: true
	})
];

let sassOptions = {
	outputStyle: 'expanded'
};

gulp.task('styles', () =>
	gulp.src('./resources/assets/scss/**/**.scss')
	.pipe(plumber({
		errorHandler: function(err) {
			console.log(err);
			this.emit('end');
		}
	}))
	.pipe(sass(sassOptions))
	.pipe(postcss(postcssPlugins))
	.pipe(plumber.stop())
	.pipe(gulp.dest('./public/css'))
	.pipe(server.stream())
);

gulp.task('compileCore', () =>
	gulp.src('./ed-grid.scss')
	.pipe(sass(sassOptions))
	.pipe(postcss(postcssPlugins))
	.pipe(gulp.dest('./css'))
);

gulp.task('scripts', () =>
	gulp.src([
		'./resources/assets/js/animations/*.js',
		'./resources/assets/js/events/*.js',
		'./resources/assets/js/utilities/*.js',
		'./resources/assets/js/validations/validations.js',
		'./resources/assets/js/validations/upload-file.js',
		'./resources/assets/js/music/music-config.js',
		'./resources/assets/js/music/music-add-edit.js',
		'./resources/assets/js/music/music-delete.js',
		'./resources/assets/js/music/music-init.js',
		'./resources/assets/js/music/music-init.js',
		'./resources/assets/js/search/*.js',
		'./resources/assets/js/user/*.js',
		'./resources/assets/js/advertising/*.js',
	])
	.pipe(concatJS('app.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('./public/js'))
);

gulp.task('sw', () =>
	gulp.watch('./resources/assets/scss/**/**.scss', ['styles'])
);

gulp.task('default', () => {
	// gulp.watch('./resources/assets/scss/**/**.scss', ['styles']);
	gulp.watch('./resources/assets/js/**/**.js', ['scripts']);
});
