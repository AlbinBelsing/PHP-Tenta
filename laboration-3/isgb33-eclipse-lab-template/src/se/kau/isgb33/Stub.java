package se.kau.isgb33;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.util.Arrays;
import java.util.Properties;

import org.bson.Document;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.mongodb.ConnectionString;
import com.mongodb.MongoClientSettings;
import com.mongodb.client.AggregateIterable;
import com.mongodb.client.MongoClient;
import com.mongodb.client.MongoClients;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoCursor;
import com.mongodb.client.MongoDatabase;
import com.mongodb.client.model.Aggregates;
import com.mongodb.client.model.Filters;
import com.mongodb.client.model.Projections;
import com.mongodb.client.model.Sorts;

import org.bson.conversions.Bson;

import javax.swing.*;
import java.awt.event.*;

public class Stub {

    public static void main(String[] args) {

        JFrame f = new JFrame("moc.xilfteN");
        f.setSize(400, 500);
        f.setLayout(null);

        JTextArea area = new JTextArea();
        area.setBounds(10, 10, 365, 400);
        area.setLineWrap(true);

        JTextField t = new JTextField("");
        t.setBounds(10, 415, 260, 40);
        

        JButton b = new JButton("Sök!");
        b.setBounds(275, 415, 100, 40);
        
        f.add(area);
		f.add(t);
		f.add(b);
		f.setVisible(true);

        String connString;
        Logger logger = LoggerFactory.getLogger(Stub.class);
        try (InputStream input = new FileInputStream("connection.properties")) {

            Properties prop = new Properties();
            prop.load(input);
            connString = prop.getProperty("db.connection_string");
            logger.info(connString);

            ConnectionString connectionString = new ConnectionString(connString);
            MongoClientSettings settings = MongoClientSettings.builder().applyConnectionString(connectionString)
                    .build();
            MongoClient mongoClient = MongoClients.create(settings);
            MongoDatabase database = mongoClient.getDatabase(prop.getProperty("db.name"));
            MongoCollection<Document> collection = database.getCollection("movies");

            b.addActionListener(new ActionListener() {

                public void actionPerformed(ActionEvent e) {

                    String genre = t.getText().trim(); //Sätter variablen genre till det man söker efter samt trimmar bort eventuella mellanslag

                    //Modifierad kod från isgb33-eclipse-f6-example
                    Bson filter = Filters.regex("genres", genre, "i"); //söker ut genres i mondogb från genre variablen, "i" är för case insensative

                    AggregateIterable<Document> sokning = collection.aggregate(Arrays.asList( 
                            Aggregates.project(Projections.include("title", "year", "genres")), //Inkluderar title, year och genres från mongodb
                            Aggregates.match(filter), //Matchar filter ovan
                            Aggregates.limit(10), //Max 10 resultat
                            Aggregates.sort(Sorts.descending("title")) //Sorterar efter title, Z-A bokstavsordning
                    ));

                    MongoCursor<Document> iterator = sokning.iterator(); //Itererar över mongodb resultaten 

                    area.setText(""); //rensar textarean mellan varje sökning

                    
                    if (!iterator.hasNext()) { //Om inget matchar så skrivs felmeddelande ut 
                        area.append("Ingen film matchade kategorin");
                    } else {
                        while (iterator.hasNext()) { //Matchar så itererar man igenom och skriver ut title + year i area
                            Document myDoc = iterator.next();
                            area.append(myDoc.getString("title") + ", "); 
                            area.append(myDoc.getInteger("year") + "\n"); 
                           
                        }
                    }

                }
            });
            
            t.addKeyListener(new KeyAdapter() { //Lägger till så man kan klicka "Enter" för att söka 
            	public void keyPressed(KeyEvent e) {
            		if(e.getKeyCode()== KeyEvent.VK_ENTER) {
            			b.doClick();
            		}
            	}
            });

        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        
    }
}

