const gulp = require('gulp');
const sass = require('gulp-sass');
const plumber = require('gulp-plumber');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const browserify = require('browserify');
const babelify = require('babelify');
const buffer = require('vinyl-buffer');
const source = require('vinyl-source-stream');
const concatJS = require('gulp-concat');
const uglify = require('gulp-uglify');
const babel = require('gulp-babel');

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
        './resources/assets/js/search/*.js',
        './resources/assets/js/user/*.js',
        './resources/assets/js/advertising/*.js',
        './resources/assets/js/todolist.js',
    ])
    .pipe(babel({
        presets: ['es2015']
    }))
    .pipe(concatJS('app.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('./public/js'))
);

gulp.task('forgot', () =>
    gulp.src([
        './resources/assets/js/forgotpassword.js',
    ])
    .pipe(babel({
        presets: ['es2015']
    }))
    .pipe(concatJS('forgotpassword.min.js'))
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