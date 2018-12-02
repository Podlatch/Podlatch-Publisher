var gulp = require('gulp');
var cssnano = require('gulp-cssnano');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sass = require('gulp-sass');

gulp.task('sass', function () {
    gulp.src([
        './node_modules/bulma/scss/*.sass',
        './app/Resources/public/sass/*.scss',
        './src/Podlatch/**/Resources/public/sass/*.scss'
    ])
        .pipe(sass({sourceComments: 'map'}).on('error', sass.logError))
        .pipe(cssnano())
        .pipe(rename('master.css'))
        .pipe(gulp.dest('./web/css/'));
});

gulp.task('js', function() {
    gulp.src([
        './node_modules/jquery/dist/jquery.js',
        './web/components/requirejs/require.js',

        './src/Podlatch/**/Resources/public/js/*.js'
    ])
        .pipe(concat('app.js'))
        .pipe(gulp.dest('./web/js'))
        .pipe(rename('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./web/js'));
});

gulp.task('podlove', function() {
    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/podlove/style.css'
    ])
        .pipe(cssnano())
        .pipe(gulp.dest('./web/'));
    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/podlove/embed.js'
    ])
        .pipe(concat('podlove-embed.js'))
        .pipe(gulp.dest('./web/js'));

    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/podlove/vendor.js'
    ])
        .pipe(gulp.dest('./web/'));

    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/podlove/fonts/*'
    ])
        .pipe(gulp.dest('./web/fonts'));

    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/podlove//window.js'
    ])
        .pipe(gulp.dest('./web/'));

    gulp.src([
        './src/Podlatch/PublisherFrontendBundle/Resources/public/vendor/subscribe_button/*',
        './src/Podlatch/PublisherFrontendBundle/Resources/public/vendor/subscribe_button/**/*'
    ])
        .pipe(gulp.dest('./web/subscribe-button'));

});