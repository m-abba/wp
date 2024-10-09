/**
 * WebSitesGen is a GUI application to generate HTML files containing links to
 * students' Coreteaching accounts and GitHub accounts based on input from IExplore.
 * The user pastes the data into the provided text area, specifies the output filename,
 * and clicks a button to generate the HTML file.
 * Written by Eddie Vanda, annotated by ChatGPT
 */
import java.awt.*;
import javax.swing.*;
import java.awt.event.*;
import javax.swing.event.*;
import java.text.*;
import java.io.*;
import java.util.*;

public class WebSitesGen extends JFrame implements ActionListener{
  JLabel instruction1 = new JLabel ("Paste your class from IExplore, then press button");
  JTextArea ta = new  JTextArea (20, 60);
  JScrollPane sp = new JScrollPane (ta);
  JTextArea lta = new   JTextArea (7, 60);
  JScrollPane lsp = new JScrollPane (lta);
  JTextField tf = new JTextField (10);
  JLabel instruction2 = new JLabel ("Type your output filename here, I will add .html:");
  JButton b = new JButton ("Press to generate file after you have pasted the iexplore contents");
  Scanner sin = null;
  String section = null;
  
  public WebSitesGen() {  // constructor
    super("Ed's WebSitesGen href generator");
    JPanel p = new JPanel ();
    p.add (instruction2);
    p.add (tf);
    b.addActionListener (this);
    p.add (b);
    p.add (instruction1);
    add (p, BorderLayout.NORTH);
    add (sp, BorderLayout.CENTER);
    add (lsp, BorderLayout.SOUTH);
    setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
    setBounds (10, 10, 900, 600);   // position & size on screen
    setVisible(true);    //Display the window.
  }

  public static void main(String[] args) {
    new WebSitesGen();
  }


  //@Override
  public void actionPerformed (ActionEvent ae) {
    String fileName = null;
    FileWriter myWriter = null;
    section = tf.getText ();
    if (section == null || section.length () == 0)
      lta.append ("Please type in a file name, e.g., 'F20E'\n");
    else {
      fileName = section + ".html";
      lta.append ("Output to file " + fileName +  "\n");
      myWriter = open (fileName);
      if (myWriter == null) 
        lta.append ("Failed to open " + fileName + "\n");
      else {
        String input = ta.getText ();
        lta.append ("actionPerformed working on " + input.length () + " characters\n");
        //Log.mes ("\n***\n" + input + "\n***\n");
        if (input == null || input.length () == 0)
          lta.append ("Please paste student info from iexplore\n");
        else {
          write ("<h3>" + section + "</h3>", myWriter);
          sin = new Scanner (input);
          generate(sin, myWriter); 
        }
        close (myWriter);
      }
    }
  }   

  void generate (Scanner sin, FileWriter myWriter) {
    String line = null;
    while (sin.hasNextLine()) {
      line = sin.nextLine ();
      if (line.length() > 20) {
        try {
          //Log.mes ("generate line = " + line);
          String [] linea = line.split ("\t");
          //if (linea.length > 1)
          //  Log.mes("generate " + linea.length + " " + linea[0]  + " " + linea[1] );
          if (linea.length > 1) {
            dealWithStudentEntry (linea[0], linea[1], myWriter);
          }
        } catch (Exception e) {} // got to end of input
      }// end if (line.length() >
      //lta.append ("got to end of input\n");
    }
  }
  
  String prefix = "<a href=\"http://jupiter.csit.rmit.edu.au/~s";
  String gitHubStringStart = "<a href=\"https://github.com/s";
  String gitHubStringEnd = "/wp\" target=\"__blank\">";
  String midfix = "\" target=\"__blank\">";
  String postfixA = "</a>&nbsp;\n";
  String postfixBr = "<br><br>\n";
  void dealWithStudentEntry (String sn, String nm, FileWriter myWriter){
    if (sn.length () >= 7 ) {
      if (Character.isDigit (sn.charAt (0))) {
        lta.append ("dealWithStudentEntry sn: " + sn + ", nm: " + nm + "\n");
        write (sn + " ", myWriter);
        write (prefix, myWriter);
        write (sn + " ", myWriter);
        write (midfix, myWriter);
        write (sn + " " + nm, myWriter);
        write (postfixA, myWriter);
        write(gitHubStringStart, myWriter);
        write(sn + "", myWriter);
        write(gitHubStringEnd, myWriter);
        write("GitHub", myWriter);
        write(postfixA, myWriter);
        write(postfixBr, myWriter);
      }
    }
  }
  
  String start1 = "<html>\n<head>\n<title>";
  String start2 = "</title>\n</head>\n<body style=\"font-size: large; font-family: Arial\">";
      
  FileWriter open (String fileName) {   
    FileWriter myWriter = null;
    try {
      myWriter = new FileWriter(fileName);
      write (start1, myWriter);
      write (section, myWriter);
      write (start2, myWriter);
    } catch (IOException e) {
      lta.append("An error occurred in file open.\n");
      lta.append(e.toString ());
    }
    return myWriter;
  }
  
  
  void write (String line, FileWriter myWriter) {  
    try {
      myWriter.write (line);
    } catch (IOException e) {
      lta.append("An error occurred in file write.\n");
      lta.append(e.toString ());
    }
  
  }  
  String endMsg = "</body>\n</html>";
  void close (FileWriter myWriter) {    
    try {
      write (endMsg, myWriter);
      myWriter.close();
    } catch (IOException e) {
      lta.append("An error occurred in file close.\n");
      lta.append(e.toString ());
    }
  }

  
} // end WebSitesGen







