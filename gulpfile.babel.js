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

const server = browserSync.create();

let postcssPlugins = [
  autoprefixer({browsers: 'last 2 versions'}),
  cssnano({core:true})
];

let sassOptions = {
  outputStyle: 'expanded'
};

gulp.task('styles', () =>
  gulp.src('./resources/assets/scss/**/**.scss')
      .pipe(plumber({
        errorHandler: function (err) {
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
  browserify('./js/babel/index.js', {
      debug: true,
      standalone: 'edgrid'
    })
    .transform(babelify)
    .bundle()
    .pipe(source('ed-grid.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./js'))
);

gulp.task('sw', () =>
  gulp.watch('./resources/assets/scss/**/**.scss', ['styles'])
);

gulp.task('default', () => {
    gulp.watch('./resources/assets/scss/**/**.scss', ['styles']);
    // gulp.watch('./resources/assets/js/**/**.js', ['scripts']);
});
