package info.zonglovani.jtv;

import android.os.Bundle;
import org.apache.cordova.*;

import android.app.Activity;
import android.view.Menu;
import android.view.MenuItem;

public class jtv extends CordovaActivity
{
    @Override
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        super.loadUrl(Config.getStartUrl());
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu, menu);
        return true;
    }   

		@Override
		public boolean onOptionsItemSelected(MenuItem item) {
				// Handle item selection
				switch (item.getItemId()) {
				case R.id.info:
        		super.loadUrl("file:///android_asset/www/about.html");
						return true;
				default:
						return super.onOptionsItemSelected(item);
				}
		}
}

