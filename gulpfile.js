const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass')); // Use Dart Sass
const cleanCSS = require('gulp-clean-css'); // minify css
const imagemin = require('gulp-imagemin'); // minify images
const concat = require('gulp-concat'); // concat js
const uglify = require('gulp-uglify'); // compress js
const watch = require('gulp-watch'); // watch all files

gulp.task('sass', function() {
    return gulp.src('assets/scss/style.scss')
        .pipe(sass())
        .pipe(cleanCSS({ compatibility: 'ie8' }))
        .pipe(gulp.dest('assets/dist/css'))
});

gulp.task('scripts', function() {
    return gulp.src(['assets/js/vendor/*.js', 'assets/js/scripts/*.js'])
        .pipe(uglify())
        .pipe(concat('main.js'))
        .pipe(gulp.dest('assets/dist/js'))
});

gulp.task('imagemin', function() {
    gulp.src('assets/images/*')
        .pipe(imagemin())
        .pipe(gulp.dest('assets/dist/images'))
});

gulp.task('watch', function() {

    gulp.watch('assets/scss/**/*.scss', gulp.series('sass'));
    gulp.watch(['assets/js/vendor/*.js', 'assets/js/scripts/*.js'], gulp.series('scripts'));
    gulp.watch('assets/images/*', gulp.series('imagemin'));

});