var gulp = require('gulp');
var cssnano = require('gulp-cssnano');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sass = require('gulp-sass');

gulp.task('sass', gulp.series(function () {
    return gulp.src([
        './node_modules/spectre.css/src/spectre.scss',
        './node_modules/spectre.css/src/spectre-exp.scss',
        './node_modules/spectre.css/src/spectre-icons.scss',
        './app/Resources/public/sass/*.scss',
        './src/Podlatch/**/Resources/public/sass/*.scss',
    ])
        .pipe(sass({sourceComments: 'map'}).on('error', sass.logError))
        .pipe(cssnano())
        .pipe(concat('all.css'))
        .pipe(rename('master.css'))
        .pipe(gulp.dest('./web/css/'));
}));

gulp.task('icons', gulp.series(function () {
    return gulp.src(
        ['./src/Podlatch/PublisherFrontendBundle/Resources/public/icons/openionic/*.svg'])
        .pipe(gulp.dest('./web/fonts/svg/'));

}));

gulp.task('backendsass', gulp.series(function () {
    return gulp.src([
        './src/Podlatch/PublisherBackendBundle/Resources/public/sass/*.scss',
    ])
        .pipe(sass({sourceComments: 'map'}).on('error', sass.logError))
        .pipe(cssnano())
        .pipe(concat('all.css'))
        .pipe(rename('backend.min.css'))
        .pipe(gulp.dest('./web/css/'));
}));

gulp.task('backendjs', gulp.series(function() {
    return gulp.src([
        './node_modules/darkmode-js/lib/darkmode-js.min.js',
        './src/Podlatch/PublisherBackendBundle/Resources/public/js/tingle.min.js',
        './src/Podlatch/PublisherBackendBundle/Resources/public/js/backend.js',
    ])
        .pipe(concat('app.js'))
        .pipe(gulp.dest('./web/js'))
        .pipe(rename('backend.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./web/js'));
}));

gulp.task('js', gulp.series(function() {
    return gulp.src([
        './node_modules/jquery/dist/jquery.js',
        './web/components/requirejs/require.js',
        './node_modules/perfect-scrollbar/dist/perfect-scrollbar.js',
        './src/Podlatch/**/Resources/public/js/*.js'
    ], { allowEmpty: true })
        .pipe(concat('app.js'))
        .pipe(gulp.dest('./web/js'))
        .pipe(rename('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./web/js'));
}));

gulp.task('podlove', gulp.series(function() {
    gulp.src([
        './node_modules/@podlove/web-player/5.0.1-beta.5/player/styles.css'
    ])
        .pipe(cssnano())
        .pipe(gulp.dest('./web/5.0.1-beta.5/player/'));

    gulp.src([
        './node_modules/perfect-scrollbar/css/perfect-scrollbar.css',
    ])
        .pipe(cssnano())
        .pipe(gulp.dest('./web/css'));


    gulp.src([
        './node_modules/@podlove/web-player/embed.js'
    ])
        .pipe(concat('podlove-embed.js'))
        .pipe(gulp.dest('./web/js'));


    gulp.src([
        './node_modules/@podlove/web-player/5.0.1-beta.5/player/*.js'
    ])
        .pipe(gulp.dest('./web/5.0.1-beta.5/player/'));

    gulp.src([
        './node_modules/@podlove/podlove-web-player/dist/fonts/*'
    ])
        .pipe(gulp.dest('./web/fonts'));

    gulp.src([
        './node_modules/@podlove/web-player/variant-xl.js'
    ])
        .pipe(gulp.dest('./web/'));

    gulp.src([
        './node_modules/@podlove/web-player/variant-l.js'
    ])
        .pipe(gulp.dest('./web/'));

    gulp.src([
        './node_modules/@podlove/web-player/variant-m.js'
    ])
        .pipe(gulp.dest('./web/'));

    return gulp.src([
        './src/Podlatch/PublisherFrontendBundle/Resources/public/vendor/subscribe_button/*',
        './src/Podlatch/PublisherFrontendBundle/Resources/public/vendor/subscribe_button/**/*'
    ])
        .pipe(gulp.dest('./web/subscribe-button'));

}));