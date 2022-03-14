def binary():
    print("\nThis is a Binary Coversion")
    inb = int(input("Enter The Binary Code: "))
    string_bin = str(inb)
    deco = int(string_bin,2)
    print("\nDecimal: "+str(deco))
    print("Hex: " + str(hex(deco)[2:]).upper())
    print("Octal: " + str(oct(deco)[2:]) + "\n")
    exit()

def decimal():
    print("\nThis Is Decimal Conversion")
    ind = int(input("Enter The Decimal Code: "))
    print("\nBinary: "+str(bin(ind)[2:]))
    print("Hex: " + str(hex(ind)[2:]).upper())
    print("Octal: " + str(oct(ind)[2:].upper()) + "\n")
    exit()

def octal():
    print("\nThis Is Octal Conversion")
    ino = int(input("Enter The Octal Code: "))
    deco = int(str(ino), 8)
    print("\nBinary: " + str(bin(deco)[2:]))
    print("Decimal: " + str(deco))
    print("Hex: " + str(hex(deco)[2:]).upper() + "\n")
    exit()

def hexa():
    print("\nThis Is Hex Conversion")
    inx = input("Enter The Hex Code: ")
    deco = int(str(inx), 16)
    print("\nBinary: " + str(bin(deco)[2:]))
    print("Decimal: " + str(deco))
    print("Octal: "+ str(oct(deco)[2:]).upper() + "\n")
    exit()


print(
    "\n\n\n##################################################\n"
    "Decimal, Binary, Octal, and Hexadecimal Calculator\n"
    "                  by: Ricky Aston                 \n\n"
    "//////////////////////////////////////////////////\n\n"
    "This program is converts between\n"
    "Binary (base 2), Octal (base 8)\n"
    "Decimal (base 10), or Hexadecimal (base 16)\n"
    "##################################################\n"
    )
print("MENU\n")

a = "1"
b = "2"
c = "3"
d = "4"
e = "5"

while(True):
    print(" [1] for Binary\n [2] for Decimal\n [3] for Octal\n [4] for Hexadecimal\n [5] for Exit\n")
    f = input("Enter the type of data you want to convert : ")

    if f == a:
        binary()
    elif f == b:
        decimal()
    elif f == c:
        octal()
    elif f == d:
        hexa()
    elif (f == e):
        exit()