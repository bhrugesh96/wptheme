/*================ Variables ================*/

var gulp = require('gulp'),
  browserSync = require('browser-sync').create(),
  cleanCss = require('gulp-clean-css'),
  concat = require('gulp-concat'),
  uglify = require('gulp-uglify'),
  prefix = require('gulp-autoprefixer'),
  sourcemaps = require('gulp-sourcemaps'),
  sass = require('gulp-sass')(require('node-sass'));

/*================ gulp-sass ================*/

gulp.task('sass', function () {
  gulp.src('inc/scss/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(gulp.dest('inc/css/src'))
    .pipe(prefix('last 2 versions'))
    .pipe(concat('main.min.css')) // concatinated css file inc/css/main.css
    .pipe(cleanCss())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('dist')) // minified css file dist/main.min.css
    .pipe(browserSync.reload({
      stream: true // watched by BrowserSync
    }))
});

/*================ gulp-concat & gulp-uglify ================*/

gulp.task('concat', function () {

  gulp.src([
    'inc/js/vendors/*.js'
  ])
    .pipe(concat('vendors.js'))
    .pipe(gulp.dest('inc/js/src'));

  gulp.src([
    'inc/js/*.js'
  ])
    .pipe(concat('main.js'))
    .pipe(gulp.dest('inc/js/src'));

  gulp.src([
    'inc/js/vendors/*.js'
  ])
    .pipe(concat('vendors.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('dist'));

  gulp.src([
    'inc/js/*.js',
  ])
    .pipe(concat('main.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('dist'));
});

/*================ browser-sync ================*/

gulp.task('browserSync', function () {
  browserSync.init({
    proxy: "http://localhost/armcodirect/", // Replace this with your local dev environment to work with BrowserSync local host
    watchTask: true,
  })
});

/*================ gulp-watch ================*/

gulp.task('default', gulp.parallel('browserSync', 'sass', 'concat', function (done) {
  gulp.watch('inc/scss/**/*.scss').on('change', gulp.series('sass', 'browserSync'));
  gulp.watch('inc/js/*.js').on('change', gulp.series('concat'));
  done();
}));
