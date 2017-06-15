var gulp = require('gulp');
// Requires the gulp-sass plugin
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();

gulp.task('sass', function() {
    return gulp.src('public/assets/custom/scss/**/*.scss') // Gets all files ending with .scss in app/scss and children dirs
        .pipe(sass())
        .pipe(gulp.dest('public/assets/custom/css/'))
        .pipe(browserSync.reload({
            stream: true
        }))
});

gulp.task('default', function(){
    gulp.watch('public/assets/custom/scss/**/*.scss', ['sass']);
    // Other watchers
});