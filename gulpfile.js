const gulp = require('gulp'),
    gulpLoadPlugins = require('gulp-load-plugins'),
    plugins = gulpLoadPlugins();

const plugin_src = {
    js: [
        'public/js/*.js',
        '!public/js/*.min.js'
    ],
    css: [
        'public/css/*.less'
    ]
};

gulp.task('js', function () {
    return gulp.src(plugin_src.js)
        .pipe(plugins.plumber())
        .pipe(plugins.uglify({
            compress: true,
            preserveComments: 'all'
        }))
        .pipe(plugins.rename({
            extname: ".js",
            suffix: ".min"
        }))
        .pipe(gulp.dest(function (file) {
            return file.base;
        }))
        .pipe(plugins.notify({message: 'Скрипты плагина собрались'}));
});

gulp.task('css', function () {
    return gulp.src(plugin_src.css)
        .pipe(plugins.plumber())
        .pipe(plugins.less())
        .pipe(plugins.autoprefixer(['last 3 versions']))
        .pipe(plugins.csso())
        .pipe(plugins.rename({
            extname: ".css"
        }))
        .pipe(gulp.dest(function (file) {
            return file.base;
        }))
        .pipe(plugins.notify({message: 'Стили плагина собрались'}));
});

gulp.task('watch', function () {

    gulp.watch(
        plugin_src.js
        , function (event) {
            plugin_src.js = [event.path];
            gulp.start('js');
        }
    );

    gulp.watch(
        plugin_src.css
        , function (event) {
            plugin_src.css = [event.path];
            gulp.start('css');
        });
});

gulp.task('default', ['watch']);


