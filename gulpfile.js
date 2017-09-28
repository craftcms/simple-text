var gulp = require('gulp');

behavePath = 'bower_components/behave.js';

gulp.task('behave.js', function() {
    return gulp.src([behavePath+'/*.js', behavePath+'/*.map'])
        .pipe(gulp.dest('lib/behave.js'));
});

gulp.task('default', ['behave.js']);
