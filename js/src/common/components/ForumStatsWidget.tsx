import app from 'flarum/common/app';
import Tooltip from 'flarum/common/components/Tooltip';
import icon from 'flarum/common/helpers/icon';
import Widget from 'flarum/extensions/afrux-forum-widgets-core/common/components/Widget';
import extractText from 'flarum/common/utils/extractText';

export default class ForumStatsWidgetWidget extends Widget {
  className(): string {
    return 'Litalino-ForumStatsWidgetWidget';
  }

  icon(): string {
    return 'fas fa-chart-pie';
  }

  title(): string {
    return extractText(app.translator.trans('flarum-forum-stats-widget.forum.widget.title'));
  }

  content() {
    const stats = app.forum.attribute('litalino-flarum-forum-stats-widget.stats');

    return (
      <div className="Litalino-ForumStatsWidget-grid">
        {Object.keys(stats).map((stat) => (
          <Tooltip text={stats[stat].label}>
            <span className="Litalino-ForumStatsWidget-grid-item">
              <span className="Litalino-ForumStatsWidget-grid-item-icon">{icon(stats[stat].icon)}</span>
              <span className="Litalino-ForumStatsWidget-grid-item-value">{stats[stat].prettyValue}</span>
            </span>
          </Tooltip>
        ))}
      </div>
    );
  }
}
