import registerWidget from '../common/registerWidget';

app.initializers.add('litalino/forum-stats-widget', () => {
  registerWidget(app);
});
