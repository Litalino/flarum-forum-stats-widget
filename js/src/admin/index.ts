import registerWidget from '../common/registerWidget';

app.initializers.add('litalino/flarum-forum-stats-widget', () => {
  registerWidget(app);
});
