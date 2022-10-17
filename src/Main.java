import java.sql.*;
import java.util.Scanner;

public class Main
{
    public static void main(String[] args) throws ClassNotFoundException, SQLException {
        AccessData ad = new AccessData();
        System.out.println(ad.loadDriver());
        System.out.println(ad.connection(args[0], args[1]));
        boolean end = false;

        Scanner sc = new Scanner(System.in);
        while (!end)
        {
            System.out.print("\nPlease choose an action :\n1. List of available vehicles\n" +
                    "2. MAJ booking calendar\n3. Location's amount\n4. Agencies with all vehicles' categories\n" +
                    "5. Clients who have located 2 different models \n6. Exit\n>> ");
            int choice = sc.nextInt();
            sc.nextLine();


            String p1,p2,p3, p4;
            boolean b1;
            int i1;
            switch (choice)
            {
                case 1:
                    System.out.print("Category: ");
                    p1 = sc.nextLine();
                    System.out.print("Start date (DD/MM/YYYY): ");
                    p2 = sc.nextLine();
                    System.out.print("End date (DD/MM/YYYY): ");
                    p3 = sc.nextLine();
                    System.out.println("\n" + ad.listVehic(p1,p2,p3));
                    break;
                case 2:
                    System.out.print("Plate: ");
                    p1 = sc.nextLine();
                    System.out.print("Start date (DD/MM/YYYY): ");
                    p2 = sc.nextLine();
                    System.out.print("End date (DD/MM/YYYY): ");
                    p3 = sc.nextLine();
                    do {
                        System.out.print("1: Add or 2: Cancel location : ");
                        i1 = sc.nextInt();
                    }
                    while (i1 != 1 && i1 != 2);

                    System.out.println("\n" + ad.majCal(p1, p2, p3, i1));
                    break;
                case 3:
                    System.out.print("Model: ");
                    p1 = sc.nextLine();
                    System.out.print("Location duration: ");
                    p2 = sc.nextLine();
                    System.out.println("\n" + ad.locAmount(p1,p2));
                    break;
                case 4:
                    System.out.println("\n" + ad.allCategsAgencies());
                    break;
                case 5:
                    System.out.println("\n" + ad.cliList2Models());
                    break;
                case 6:
                    end = true;
                    break;
                default:
                    break;
            }
        }

    }

}
