var gulp = require('gulp');
var cssnano = require('gulp-cssnano');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sass = require('gulp-sass');

gulp.task('sass', function () {
    gulp.src([
        './app/Resources/public/sass/*.scss',
        './src/Podlatch/**/Resources/public/sass/*.scss'
    ])
        .pipe(sass({sourceComments: 'map'}).on('error', sass.logError))
        .pipe(cssnano())
        .pipe(gulp.dest('./web/css/'));
});

gulp.task('js', function() {
    gulp.src([
        './node_modules/jquery/dist/jquery.js',
        './src/Podlatch/**/Resources/public/js/*.js',
        './node_modules/bootstrap-sass/javascripts/assets/*.js',
        './web/components/requirejs/require.js'
    ])
        .pipe(concat('app.js'))
        .pipe(gulp.dest('./web/js'))
        .pipe(rename('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./web/js'));
});