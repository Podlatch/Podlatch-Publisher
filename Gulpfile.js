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
        './src/Podlatch/**/Resources/public/sass/*.scss',
    ])
        .pipe(sass({sourceComments: 'map'}).on('error', sass.logError))
        .pipe(cssnano())
        .pipe(concat('all.css'))
        .pipe(rename('master.css'))
        .pipe(gulp.dest('./web/css/'));
});

gulp.task('icons', function () {
    gulp.src(
        ['./src/Podlatch/PublisherFrontendBundle/Resources/public/icons/openionic/*.svg'])
        .pipe(gulp.dest('./web/fonts/svg/'));

});

gulp.task('backendsass', function () {
    gulp.src([
        './src/Podlatch/PublisherBackendBundle/Resources/public/sass/*.scss',
    ])
        .pipe(sass({sourceComments: 'map'}).on('error', sass.logError))
        .pipe(cssnano())
        .pipe(concat('all.css'))
        .pipe(rename('backend.min.css'))
        .pipe(gulp.dest('./web/css/'));
});

gulp.task('backendjs', function() {
    gulp.src([
        './src/Podlatch/PublisherBackendBundle/Resources/public/js/tingle.min.js',
        './src/Podlatch/PublisherBackendBundle/Resources/public/js/backend.js',
    ])
        .pipe(concat('app.js'))
        .pipe(gulp.dest('./web/js'))
        .pipe(rename('backend.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./web/js'));
});

gulp.task('js', function() {
    gulp.src([
        './node_modules/jquery/dist/jquery.js',
        './web/components/requirejs/require.js',
        './node_modules/perfect-scrollbar/dist/perfect-scrollbar.js',
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
        './node_modules/@podlove/podlove-web-player/dist/style.css'
    ])
        .pipe(cssnano())
        .pipe(gulp.dest('./web/'));

    gulp.src([
        './node_modules/perfect-scrollbar/css/perfect-scrollbar.css',
    ])
        .pipe(cssnano())
        .pipe(gulp.dest('./web/css'));


    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/embed.js'
    ])
        .pipe(concat('podlove-embed.js'))
        .pipe(gulp.dest('./web/js'));

    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/style.js'
    ])
        .pipe(gulp.dest('./web/'));

    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/vendor.js'
    ])
        .pipe(gulp.dest('./web/'));

    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/fonts/*'
    ])
        .pipe(gulp.dest('./web/fonts'));

    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/window.js'
    ])
        .pipe(gulp.dest('./web/'));

    gulp.src([
        './src/Podlatch/PublisherFrontendBundle/Resources/public/vendor/subscribe_button/*',
        './src/Podlatch/PublisherFrontendBundle/Resources/public/vendor/subscribe_button/**/*'
    ])
        .pipe(gulp.dest('./web/subscribe-button'));

});